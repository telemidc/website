@extends('layouts.admin')
@section('title', 'المسجلون في الدورة')
@section('content')
<div style="margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline"><i class="ph ph-arrow-right"></i> العودة للدورات</a>
</div>
<div class="card">
    <div class="card-header">
        <h3><i class="ph ph-users" style="color:var(--orange)"></i> المسجلون في: <strong>{{ $course->name }}</strong></h3>
        <div style="display:flex;gap:12px;align-items:center;">
            <form method="GET" class="search-box">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث باسم الطالب أو الهاتف...">
                <button type="submit"><i class="ph ph-magnifying-glass"></i></button>
            </form>
            <span class="badge badge-hired">{{ $registrations->count() }} / {{ $course->max_students }}</span>
        </div>
    </div>
    <table>
        <thead><tr><th>#</th><th>اسم الطالب</th><th>الدولة</th><th>البريد الإلكتروني</th><th>رقم الهاتف</th><th>الشهادة</th><th>تاريخ التسجيل</th></tr></thead>
        <tbody>
            @forelse($registrations as $r)
            <tr>
                <td>{{ $registrations->firstItem() + $loop->index }}</td>
                <td><strong>{{ $r->student_name }}</strong></td>
                <td>{{ $r->country }}</td>
                <td>{{ $r->email }}</td>
                <td dir="ltr" style="text-align:right;">{{ $r->phone }}</td>
                <td>
                    @if($r->certificate)
                        <a href="{{ route('admin.certificates.pdf', $r->certificate) }}" class="btn btn-success btn-sm" target="_blank"><i class="ph ph-file-pdf"></i> تحميل</a>
                    @else
                        <a href="{{ route('admin.certificates.create', ['registration_id' => $r->id]) }}" class="btn btn-outline btn-sm"><i class="ph ph-plus"></i> إصدار شهادة</a>
                    @endif
                </td>
                <td>{{ $r->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:30px;color:var(--text-gray);">لا يوجد طلاب مسجلون حالياً.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($registrations->hasPages())
    <div style="padding:16px 20px;">{{ $registrations->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
