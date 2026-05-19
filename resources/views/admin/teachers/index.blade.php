@extends('layouts.admin')
@section('title', 'الأساتذة والخبراء')
@section('content')

<div class="card">
    <div class="card-header">
        <h3><i class="ph ph-users-three" style="color:var(--orange)"></i> الأساتذة والخبراء</h3>
        <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
            <form method="GET" class="search-box">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالاسم أو الهاتف...">
                <button type="submit"><i class="ph ph-magnifying-glass"></i></button>
            </form>
            <button class="btn btn-primary" onclick="document.getElementById('directModal').classList.add('open')">
                <i class="ph ph-plus"></i> إضافة أستاذ مباشرة
            </button>
        </div>
    </div>
    <table>
        <thead><tr><th>الاسم</th><th>المجال</th><th>البريد / الهاتف</th><th>الملخص</th><th>الحالة</th><th>العقد</th><th>إجراءات</th></tr></thead>
        <tbody>
            @forelse($applications as $teacher)
            <tr>
                <td><strong>{{ $teacher->name }}</strong></td>
                <td>{{ $teacher->field->name ?? '-' }}</td>
                <td>
                    {{ $teacher->email }}<br>
                    <small dir="ltr">{{ $teacher->phone }}</small>
                </td>
                <td style="max-width:200px;font-size:.82rem;color:var(--text-gray);">{{ Str::limit($teacher->bio, 80) }}</td>
                <td><span class="badge badge-{{ $teacher->status }}">{{ $teacher->status === 'pending' ? 'معلق' : ($teacher->status === 'hired' ? 'موظف' : 'مرفوض') }}</span></td>
                <td>
                    @if($teacher->contract)
                        <small style="color:var(--text-gray);">{{ $teacher->contract->salary }} / {{ $teacher->contract->contract_duration }}</small>
                    @else
                        <span style="color:var(--text-gray);">-</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        @if($teacher->status !== 'hired')
                        <button class="btn btn-success btn-sm" onclick="openHire({{ $teacher->id }}, '{{ addslashes($teacher->name) }}')">
                            <i class="ph ph-handshake"></i> توظيف
                        </button>
                        @endif
                        @if($teacher->status !== 'rejected')
                        <form action="{{ route('admin.teachers.status', $teacher) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button class="btn btn-danger btn-sm" onclick="return confirm('رفض هذا الطلب؟')"><i class="ph ph-x"></i></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:30px;color:var(--text-gray);">لا توجد طلبات أساتذة بعد.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Hire Modal --}}
<div class="modal-overlay" id="hireModal">
    <div class="modal" style="max-width:600px;">
        <div class="modal-title">توظيف الأستاذ: <span id="teacherName"></span></div>
        <form id="hireForm" method="POST">
            @csrf
            <div class="form-group"><label class="form-label">مدة التعاقد *</label><input type="text" name="contract_duration" class="form-control" placeholder="مثال: 6 أشهر، سنة" required></div>
            <div class="form-grid">
                <div class="form-group"><label class="form-label">الراتب الشهري ($) *</label><input type="number" name="salary" class="form-control" step="0.01" min="0" required></div>
                <div class="form-group"><label class="form-label">تاريخ بداية العقد *</label><input type="date" name="start_date" class="form-control" required></div>
            </div>
            <div class="form-group"><label class="form-label">نص العقد *</label><textarea name="contract_text" class="form-control" rows="5" required></textarea></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('hireModal').classList.remove('open')">إلغاء</button>
                <button type="submit" class="btn btn-primary"><i class="ph ph-handshake"></i> تأكيد التوظيف</button>
            </div>
        </form>
    </div>
</div>

{{-- Direct Add Modal --}}
<div class="modal-overlay" id="directModal">
    <div class="modal" style="max-width:650px;">
        <div class="modal-title">إضافة وتوظيف أستاذ مباشرة</div>
        <form action="{{ route('admin.teachers.storeDirect') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group"><label class="form-label">الاسم الكامل *</label><input type="text" name="name" class="form-control" required></div>
                <div class="form-group">
                    <label class="form-label">المجال *</label>
                    <select name="field_id" class="form-control" required>
                        <option value="">اختر مجالاً</option>
                        @foreach($fields as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach
                    </select>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group"><label class="form-label">رقم الهاتف *</label><input type="text" name="phone" class="form-control" dir="ltr" required></div>
                <div class="form-group"><label class="form-label">البريد الإلكتروني *</label><input type="email" name="email" class="form-control" dir="ltr" required></div>
            </div>
            <div class="form-group"><label class="form-label">نبذة عن الأستاذ (اختياري)</label><textarea name="bio" class="form-control" rows="2"></textarea></div>
            
            <div style="margin:20px 0;padding-top:20px;border-top:1px dashed var(--border);"><strong style="color:var(--purple-dark);font-size:1.1rem;">بيانات العقد</strong></div>
            <div class="form-grid">
                <div class="form-group"><label class="form-label">مدة التعاقد *</label><input type="text" name="contract_duration" class="form-control" placeholder="مثال: سنة" required></div>
                <div class="form-group"><label class="form-label">الراتب الشهري *</label><input type="number" name="salary" class="form-control" step="0.01" min="0" required></div>
            </div>
            <div class="form-group"><label class="form-label">تاريخ البداية *</label><input type="date" name="start_date" class="form-control" required></div>
            <div class="form-group"><label class="form-label">نص العقد *</label><textarea name="contract_text" class="form-control" rows="3" required></textarea></div>
            
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('directModal').classList.remove('open')">إلغاء</button>
                <button type="submit" class="btn btn-primary"><i class="ph ph-check"></i> حفظ كأستاذ موظف</button>
            </div>
        </form>
    </div>
</div>

<script>
function openHire(id, name) {
    document.getElementById('hireForm').action = '/admin/teachers/' + id + '/hire';
    document.getElementById('teacherName').textContent = name;
    document.getElementById('hireModal').classList.add('open');
}
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if(e.target === o) o.classList.remove('open'); }));
</script>
@endsection
