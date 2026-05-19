@extends('layouts.admin')
@section('title', 'المواد')
@section('content')

<div class="card">
    <div class="card-header">
        <h3><i class="ph ph-book-open" style="color:var(--orange)"></i> المواد الدراسية</h3>
        <button class="btn btn-primary" onclick="document.getElementById('addModal').classList.add('open')">
            <i class="ph ph-plus"></i> إضافة مادة
        </button>
    </div>
    <table>
        <thead><tr><th>#</th><th>اسم المادة</th><th>المجال</th><th>الامتحانات</th><th>إجراءات</th></tr></thead>
        <tbody>
            @forelse($subjects as $subject)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $subject->name }}</strong><br><small style="color:var(--text-gray)">{{ Str::limit($subject->description, 50) }}</small></td>
                <td><span class="badge badge-visible">{{ $subject->field->name }}</span></td>
                <td>{{ $subject->exams_count }}</td>
                <td>
                    <div style="display:flex;gap:8px;">
                        <button class="btn btn-outline btn-sm" onclick="openEdit({{ $subject->id }}, {{ $subject->field_id }}, '{{ addslashes($subject->name) }}', '{{ addslashes($subject->description) }}')">
                            <i class="ph ph-pencil"></i> تعديل
                        </button>
                        <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('حذف هذه المادة؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="ph ph-trash"></i> حذف</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--text-gray);">لا توجد مواد بعد.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Add Modal --}}
<div class="modal-overlay" id="addModal">
    <div class="modal">
        <div class="modal-title">إضافة مادة جديدة</div>
        <form action="{{ route('admin.subjects.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">المجال *</label>
                <select name="field_id" class="form-control" required>
                    <option value="">اختر مجالاً</option>
                    @foreach($fields as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach
                </select>
            </div>
            <div class="form-group"><label class="form-label">اسم المادة *</label><input type="text" name="name" class="form-control" required></div>
            <div class="form-group"><label class="form-label">الوصف</label><textarea name="description" class="form-control" rows="3"></textarea></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addModal').classList.remove('open')">إلغاء</button>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <div class="modal-title">تعديل المادة</div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">المجال *</label>
                <select name="field_id" id="editField" class="form-control" required>
                    @foreach($fields as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach
                </select>
            </div>
            <div class="form-group"><label class="form-label">اسم المادة *</label><input type="text" name="name" id="editName" class="form-control" required></div>
            <div class="form-group"><label class="form-label">الوصف</label><textarea name="description" id="editDesc" class="form-control" rows="3"></textarea></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editModal').classList.remove('open')">إلغاء</button>
                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            </div>
        </form>
    </div>
</div>
<script>
function openEdit(id, fieldId, name, desc) {
    document.getElementById('editForm').action = '/admin/subjects/' + id;
    document.getElementById('editField').value = fieldId;
    document.getElementById('editName').value = name;
    document.getElementById('editDesc').value = desc;
    document.getElementById('editModal').classList.add('open');
}
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if(e.target === o) o.classList.remove('open'); }));
</script>
@endsection
