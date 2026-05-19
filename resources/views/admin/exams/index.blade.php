@extends('layouts.admin')
@section('title', 'الامتحانات')
@section('content')

<div class="card">
    <div class="card-header">
        <h3><i class="ph ph-exam" style="color:var(--orange)"></i> الامتحانات</h3>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('admin.exams.results') }}" class="btn btn-outline">
                <i class="ph ph-chart-bar"></i> نتائج الامتحانات
            </a>
            <button class="btn btn-primary" onclick="document.getElementById('addModal').classList.add('open')">
                <i class="ph ph-plus"></i> إضافة امتحان
            </button>
        </div>
    </div>
    <table>
        <thead><tr><th>المادة</th><th>المجال</th><th>التاريخ</th><th>الوقت</th><th>الحالة</th><th>المسجلون</th><th>إجراءات</th></tr></thead>
        <tbody>
            @forelse($exams as $exam)
            <tr>
                <td><strong>{{ $exam->subject->name ?? '-' }}</strong></td>
                <td>{{ $exam->subject->field->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($exam->exam_date)->format('Y-m-d') }}</td>
                <td dir="ltr" style="text-align:right;">{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->end_time)->format('H:i') }}</td>
                <td>
                    <span class="{{ $exam->registrations_count >= $exam->max_students ? 'badge badge-rejected' : 'badge badge-hired' }}">
                        {{ $exam->registrations_count }} / {{ $exam->max_students }}
                    </span>
                </td>
                <td>
                    <span class="badge badge-{{ $exam->status === 'completed' ? 'rejected' : 'hired' }}">
                        <i class="ph ph-{{ $exam->status === 'completed' ? 'check-circle' : 'megaphone' }}"></i>
                        {{ $exam->status === 'completed' ? 'منجز' : 'معلن' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        <a href="{{ route('admin.exams.registrations', $exam) }}" class="btn btn-outline btn-sm"><i class="ph ph-users"></i> المسجلون</a>
                        <form action="{{ route('admin.exams.toggleStatus', $exam) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm" style="background:{{ $exam->status === 'completed' ? '#6c757d' : '#198754' }};color:#fff;border:none;" title="تغيير الحالة">
                                <i class="ph ph-{{ $exam->status === 'completed' ? 'megaphone' : 'check-circle' }}"></i>
                                {{ $exam->status === 'completed' ? 'إعادة إعلان' : 'إنجاز' }}
                            </button>
                        </form>
                        <button class="btn btn-warning btn-sm" onclick="openEdit({{ $exam->id }}, {{ $exam->subject_id }}, '{{ $exam->exam_date }}', '{{ substr($exam->start_time,0,5) }}', '{{ substr($exam->end_time,0,5) }}', {{ $exam->max_students }})"><i class="ph ph-pencil"></i></button>
                        <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" onsubmit="return confirm('حذف هذا الامتحان؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="ph ph-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:30px;color:var(--text-gray);">لا توجد امتحانات. أضف أول امتحان!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Add Modal --}}
<div class="modal-overlay" id="addModal">
    <div class="modal">
        <div class="modal-title">إضافة امتحان جديد</div>
        <form action="{{ route('admin.exams.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">المادة *</label>
                <select name="subject_id" class="form-control" required>
                    <option value="">اختر مادة</option>
                    @foreach($subjects as $s)<option value="{{ $s->id }}">{{ $s->field->name }} - {{ $s->name }}</option>@endforeach
                </select>
            </div>
            <div class="form-group"><label class="form-label">تاريخ الامتحان *</label><input type="date" name="exam_date" class="form-control" required></div>
            <div class="form-grid">
                <div class="form-group"><label class="form-label">وقت البداية *</label><input type="time" name="start_time" class="form-control" required></div>
                <div class="form-group"><label class="form-label">وقت النهاية *</label><input type="time" name="end_time" class="form-control" required></div>
            </div>
            <div class="form-group"><label class="form-label">الحد الأقصى للطلاب *</label><input type="number" name="max_students" class="form-control" value="30" min="1" required></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addModal').classList.remove('open')">إلغاء</button>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <div class="modal-title">تعديل الامتحان</div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">المادة *</label>
                <select name="subject_id" id="eSubject" class="form-control" required>
                    @foreach($subjects as $s)<option value="{{ $s->id }}">{{ $s->field->name }} - {{ $s->name }}</option>@endforeach
                </select>
            </div>
            <div class="form-group"><label class="form-label">تاريخ الامتحان *</label><input type="date" name="exam_date" id="eDate" class="form-control" required></div>
            <div class="form-grid">
                <div class="form-group"><label class="form-label">وقت البداية *</label><input type="time" name="start_time" id="eStart" class="form-control" required></div>
                <div class="form-group"><label class="form-label">وقت النهاية *</label><input type="time" name="end_time" id="eEnd" class="form-control" required></div>
            </div>
            <div class="form-group"><label class="form-label">الحد الأقصى للطلاب *</label><input type="number" name="max_students" id="eMax" class="form-control" min="1" required></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editModal').classList.remove('open')">إلغاء</button>
                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(id, sid, date, st, et, max) {
    document.getElementById('editForm').action = '/admin/exams/' + id;
    document.getElementById('eSubject').value = sid;
    document.getElementById('eDate').value = date;
    document.getElementById('eStart').value = st;
    document.getElementById('eEnd').value = et;
    document.getElementById('eMax').value = max;
    document.getElementById('editModal').classList.add('open');
}
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if(e.target === o) o.classList.remove('open'); }));
</script>
@endsection
