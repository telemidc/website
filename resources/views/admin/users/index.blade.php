@extends('layouts.admin')
@section('title', 'مدراء النظام')
@section('content')

<div class="card">
    <div class="card-header">
        <h3><i class="ph ph-shield-check" style="color:var(--orange)"></i> حسابات مدراء النظام</h3>
        <button class="btn btn-primary" onclick="document.getElementById('addModal').classList.add('open')">
            <i class="ph ph-user-plus"></i> إضافة مدير
        </button>
    </div>
    <table>
        <thead><tr><th>#</th><th>الاسم</th><th>رقم الهاتف</th><th>تاريخ الإضافة</th><th>إجراءات</th></tr></thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $user->name }}</strong> @if($user->id === auth()->id()) <span class="badge badge-visible">أنت</span> @endif</td>
                <td dir="ltr" style="text-align:right;">{{ $user->phone }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                    <div style="display:flex;gap:8px;">
                        <button class="btn btn-warning btn-sm" onclick="openEdit({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->phone }}')">
                            <i class="ph ph-pencil"></i> تعديل
                        </button>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف حساب المدير هذا؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="ph ph-trash"></i> حذف</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--text-gray);">لا يوجد مدراء في النظام.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Add Modal --}}
<div class="modal-overlay" id="addModal">
    <div class="modal">
        <div class="modal-title">إضافة مدير جديد</div>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group"><label class="form-label">الاسم الكامل *</label><input type="text" name="name" class="form-control" required></div>
            <div class="form-group"><label class="form-label">رقم الهاتف (لتسجيل الدخول) *</label><input type="text" name="phone" class="form-control" dir="ltr" required></div>
            <div class="form-group"><label class="form-label">كلمة المرور *</label><input type="password" name="password" class="form-control" required minlength="6"></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addModal').classList.remove('open')">إلغاء</button>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <div class="modal-title">تعديل بيانات المدير</div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group"><label class="form-label">الاسم الكامل *</label><input type="text" name="name" id="eName" class="form-control" required></div>
            <div class="form-group"><label class="form-label">رقم الهاتف *</label><input type="text" name="phone" id="ePhone" class="form-control" dir="ltr" required></div>
            <div class="form-group"><label class="form-label">كلمة المرور الجديدة (اختياري)</label><input type="password" name="password" class="form-control" placeholder="اتركه فارغاً لعدم التغيير" minlength="6"></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editModal').classList.remove('open')">إلغاء</button>
                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(id, name, phone) {
    document.getElementById('editForm').action = '/admin/users/' + id;
    document.getElementById('eName').value = name;
    document.getElementById('ePhone').value = phone;
    document.getElementById('editModal').classList.add('open');
}
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if(e.target === o) o.classList.remove('open'); }));
</script>
@endsection
