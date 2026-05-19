@extends('layouts.admin')
@section('title', 'التحقق من شهادة')
@section('content')
<div class="card" style="max-width:500px;">
    <div class="card-header"><h3><i class="ph ph-magnifying-glass" style="color:var(--orange)"></i> التحقق من شهادة</h3></div>
    <div class="card-body">
        <form method="GET">
            <div class="form-group"><label class="form-label">رقم الشهادة</label>
                <input type="text" name="number" class="form-control" value="{{ request('number') }}" placeholder="CRD-XXXXX" dir="ltr" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="ph ph-magnifying-glass"></i> بحث</button>
        </form>

        @if(request('number'))
            <div style="margin-top:24px;">
            @if($cert)
                <div style="background:#dcfce7;border-radius:var(--radius);padding:20px;border:2px solid #86efac;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                        <i class="ph ph-check-circle" style="font-size:2rem;color:#15803d;"></i>
                        <strong style="color:#15803d;font-size:1.1rem;">شهادة موثقة ✓</strong>
                    </div>
                    <p><strong>رقم الشهادة:</strong> {{ $cert->certificate_number }}</p>
                    <p><strong>اسم الطالب:</strong> {{ $cert->registration->student_name }}</p>
                    <p><strong>الدورة:</strong> {{ $cert->registration->course->name }}</p>
                    <p><strong>التقييم:</strong> {{ $cert->grade }}</p>
                    <p><strong>تاريخ الإصدار:</strong> {{ \Carbon\Carbon::parse($cert->issued_at)->format('Y-m-d') }}</p>
                    <div style="margin-top:12px;">
                        <a href="{{ route('admin.certificates.pdf', $cert) }}" target="_blank" class="btn btn-success btn-sm"><i class="ph ph-file-pdf"></i> تحميل الشهادة</a>
                    </div>
                </div>
            @else
                <div style="background:#fee2e2;border-radius:var(--radius);padding:20px;border:2px solid #fca5a5;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <i class="ph ph-x-circle" style="font-size:2rem;color:#b91c1c;"></i>
                        <strong style="color:#b91c1c;">لا توجد شهادة بهذا الرقم</strong>
                    </div>
                </div>
            @endif
            </div>
        @endif
    </div>
</div>
@endsection
