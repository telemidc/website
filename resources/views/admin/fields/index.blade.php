@extends('layouts.admin')
@section('title', 'المجالات التعليمية')
@section('content')

<div class="card">
    <div class="card-header">
        <h3><i class="ph ph-folders" style="color:var(--orange)"></i> المجالات التعليمية</h3>
        <button class="btn btn-primary" onclick="document.getElementById('addModal').classList.add('open')">
            <i class="ph ph-plus"></i> إضافة مجال
        </button>
    </div>
    <table>
        <thead><tr><th>#</th><th>اسم المجال</th><th>الوصف</th><th>عدد المواد</th><th>إجراءات</th></tr></thead>
        <tbody>
            @forelse($fields as $field)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $field->name }}</strong></td>
                <td style="color:var(--text-gray);max-width:300px;">{{ Str::limit($field->description, 60) ?? '-' }}</td>
                <td><span class="badge badge-visible">{{ $field->subjects_count }} مادة</span></td>
                <td>
                    <div style="display:flex;gap:8px;">
                        <button class="btn btn-outline btn-sm" onclick="openEditModal({{ $field->id }}, '{{ addslashes($field->name) }}', '{{ addslashes($field->description) }}')">
                            <i class="ph ph-pencil"></i> تعديل
                        </button>
                        <form action="{{ route('admin.fields.destroy', $field) }}" method="POST" onsubmit="return confirm('حذف هذا المجال؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="ph ph-trash"></i> حذف</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--text-gray);">لا توجد مجالات بعد. أضف أول مجال!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Add Modal --}}
<div class="modal-overlay" id="addModal">
    <div class="modal">
        <div class="modal-title">إضافة مجال جديد</div>
        <form action="{{ route('admin.fields.store') }}" method="POST">
            @csrf
            <div class="form-group"><label class="form-label">اسم المجال *</label><input type="text" name="name" class="form-control" required></div>
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
        <div class="modal-title">تعديل المجال</div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group"><label class="form-label">اسم المجال *</label><input type="text" name="name" id="editName" class="form-control" required></div>
            <div class="form-group"><label class="form-label">الوصف</label><textarea name="description" id="editDesc" class="form-control" rows="3"></textarea></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editModal').classList.remove('open')">إلغاء</button>
                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name, desc) {
    document.getElementById('editForm').action = '/admin/fields/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editDesc').value = desc;
    document.getElementById('editModal').classList.add('open');
}
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if(e.target === o) o.classList.remove('open'); }));
</script>
@endsection
