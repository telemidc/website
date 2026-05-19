@extends('layouts.admin')
@section('title', 'الدورات')
@section('content')

<div class="card">
    <div class="card-header">
        <h3><i class="ph ph-chalkboard-teacher" style="color:var(--orange)"></i> الدورات التدريبية</h3>
        <button class="btn btn-primary" onclick="document.getElementById('addModal').classList.add('open')">
            <i class="ph ph-plus"></i> إضافة دورة
        </button>
    </div>
    <table>
        <thead><tr><th>اسم الدورة</th><th>المجال</th><th>الأساتذة</th><th>الفترة</th><th>المسجلون</th><th>الحالة</th><th>إجراءات</th></tr></thead>
        <tbody>
            @forelse($courses as $course)
            <tr>
                <td><strong>{{ $course->name }}</strong></td>
                <td>{{ $course->field->name }}</td>
                <td>{{ $course->teachers->pluck('name')->join('، ') ?: '-' }}</td>
                <td style="font-size:.82rem;">{{ \Carbon\Carbon::parse($course->start_date)->format('Y-m-d') }}<br>{{ \Carbon\Carbon::parse($course->end_date)->format('Y-m-d') }}</td>
                <td><span class="badge badge-{{ $course->registrations_count >= $course->max_students ? 'rejected' : 'hired' }}">{{ $course->registrations_count }}/{{ $course->max_students }}</span></td>
                <td>
                    <span class="badge badge-{{ $course->is_visible ? 'visible' : 'hidden' }}">
                        {{ $course->is_visible ? 'مرئية' : 'مخفية' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        <a href="{{ route('admin.courses.registrations', $course) }}" class="btn btn-outline btn-sm"><i class="ph ph-users"></i></a>
                        <form action="{{ route('admin.courses.toggle', $course) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm {{ $course->is_visible ? 'btn-warning' : 'btn-success' }}" title="{{ $course->is_visible ? 'إخفاء' : 'إظهار' }}">
                                <i class="ph ph-{{ $course->is_visible ? 'eye-slash' : 'eye' }}"></i>
                            </button>
                        </form>
                        <button class="btn btn-warning btn-sm" onclick="openEdit({{ $course->id }}, '{{ addslashes($course->name) }}', {{ $course->field_id }}, '{{ addslashes($course->description) }}', '{{ $course->start_date }}', '{{ $course->end_date }}', {{ $course->max_students }}, [{{ $course->teachers->pluck('id')->join(',') }}])"><i class="ph ph-pencil"></i></button>
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('حذف الدورة؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="ph ph-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:30px;color:var(--text-gray);">لا توجد دورات بعد.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Add Modal --}}
<div class="modal-overlay" id="addModal">
    <div class="modal">
        <div class="modal-title">إضافة دورة جديدة</div>
        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf
            <div class="form-group"><label class="form-label">اسم الدورة *</label><input type="text" name="name" class="form-control" required></div>
            <div class="form-group">
                <label class="form-label">المجال *</label>
                <select name="field_id" class="form-control" required>
                    <option value="">اختر مجالاً</option>
                    @foreach($fields as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach
                </select>
            </div>
            <div class="form-group"><label class="form-label">الوصف</label><textarea name="description" class="form-control" rows="3"></textarea></div>
            <div class="form-grid">
                <div class="form-group"><label class="form-label">تاريخ البداية *</label><input type="date" name="start_date" class="form-control" required></div>
                <div class="form-group"><label class="form-label">تاريخ النهاية *</label><input type="date" name="end_date" class="form-control" required></div>
            </div>
            <div class="form-group"><label class="form-label">الحد الأقصى للطلاب *</label><input type="number" name="max_students" class="form-control" value="30" min="1" required></div>
            <div class="form-group">
                <label class="form-label">الأساتذة (اختياري)</label>
                <select name="teachers[]" class="form-control" multiple style="height:120px;">
                    @foreach($teachers as $t)<option value="{{ $t->id }}">{{ $t->name }}</option>@endforeach
                </select>
                <small style="color:var(--text-gray)">اضغط Ctrl للاختيار المتعدد</small>
            </div>
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
        <div class="modal-title">تعديل الدورة</div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group"><label class="form-label">اسم الدورة *</label><input type="text" name="name" id="eName" class="form-control" required></div>
            <div class="form-group">
                <label class="form-label">المجال *</label>
                <select name="field_id" id="eField" class="form-control" required>
                    @foreach($fields as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach
                </select>
            </div>
            <div class="form-group"><label class="form-label">الوصف</label><textarea name="description" id="eDesc" class="form-control" rows="3"></textarea></div>
            <div class="form-grid">
                <div class="form-group"><label class="form-label">تاريخ البداية *</label><input type="date" name="start_date" id="eStart" class="form-control" required></div>
                <div class="form-group"><label class="form-label">تاريخ النهاية *</label><input type="date" name="end_date" id="eEnd" class="form-control" required></div>
            </div>
            <div class="form-group"><label class="form-label">الحد الأقصى *</label><input type="number" name="max_students" id="eMax" class="form-control" min="1" required></div>
            <div class="form-group">
                <label class="form-label">الأساتذة</label>
                <select name="teachers[]" id="eTeachers" class="form-control" multiple style="height:120px;">
                    @foreach($teachers as $t)<option value="{{ $t->id }}">{{ $t->name }}</option>@endforeach
                </select>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editModal').classList.remove('open')">إلغاء</button>
                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(id, name, fieldId, desc, start, end, max, teacherIds) {
    document.getElementById('editForm').action = '/admin/courses/' + id;
    document.getElementById('eName').value = name;
    document.getElementById('eField').value = fieldId;
    document.getElementById('eDesc').value = desc;
    document.getElementById('eStart').value = start;
    document.getElementById('eEnd').value = end;
    document.getElementById('eMax').value = max;
    Array.from(document.getElementById('eTeachers').options).forEach(o => { o.selected = teacherIds.includes(parseInt(o.value)); });
    document.getElementById('editModal').classList.add('open');
}
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if(e.target === o) o.classList.remove('open'); }));
</script>
@endsection
