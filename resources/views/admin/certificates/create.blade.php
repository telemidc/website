@extends('layouts.admin')
@section('title', 'إصدار شهادة')
@section('content')
<div style="margin-bottom:20px;">
    <a href="{{ route('admin.courses.registrations', $registration->course) }}" class="btn btn-outline"><i class="ph ph-arrow-right"></i> العودة</a>
</div>
<div class="card" style="max-width:580px;">
    <div class="card-header"><h3><i class="ph ph-certificate" style="color:var(--orange)"></i> إصدار شهادة لطالب</h3></div>
    <div class="card-body">
        <div style="background:var(--off-white);border-radius:var(--radius-sm);padding:16px;margin-bottom:24px;">
            <strong>{{ $registration->student_name }}</strong> — {{ $registration->course->name }}<br>
            <small style="color:var(--text-gray)">{{ $registration->country }} | {{ $registration->email }}</small>
        </div>
        <form action="{{ route('admin.certificates.store') }}" method="POST">
            @csrf
            <input type="hidden" name="course_registration_id" value="{{ $registration->id }}">
            <div class="form-group"><label class="form-label">التقييم *</label><input type="text" name="grade" class="form-control" placeholder="مثال: ممتاز، A+، 95%" required></div>
            <div class="form-group"><label class="form-label">ملاحظات</label><textarea name="notes" class="form-control" rows="3"></textarea></div>
            <div class="form-group"><label class="form-label">تاريخ الإصدار *</label><input type="date" name="issued_at" class="form-control" value="{{ date('Y-m-d') }}" required></div>
            <button type="submit" class="btn btn-primary"><i class="ph ph-certificate"></i> إصدار الشهادة</button>
        </form>
    </div>
</div>
@endsection
