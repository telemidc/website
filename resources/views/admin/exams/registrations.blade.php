@extends('layouts.admin')
@section('title', 'المسجلون في الامتحان')
@section('content')

<div style="margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
    <a href="{{ route('admin.exams.index') }}" class="btn btn-outline"><i class="ph ph-arrow-right"></i> العودة للامتحانات</a>
    <span class="badge badge-{{ $exam->status === 'completed' ? 'rejected' : 'hired' }}" style="font-size:.85rem;padding:6px 14px;">
        <i class="ph ph-{{ $exam->status === 'completed' ? 'check-circle' : 'megaphone' }}"></i>
        {{ $exam->status === 'completed' ? 'منجز' : 'معلن' }}
    </span>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="ph ph-users" style="color:var(--orange)"></i>
            المسجلون في: <strong>{{ $exam->subject->name }}</strong>
            <small style="color:var(--text-gray);font-size:.85rem;">— {{ \Carbon\Carbon::parse($exam->exam_date)->format('Y-m-d') }}</small>
        </h3>
        <div style="display:flex;gap:12px;align-items:center;">
            <form method="GET" class="search-box">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث باسم الطالب أو الهاتف...">
                <button type="submit"><i class="ph ph-magnifying-glass"></i></button>
            </form>
            <span class="badge badge-{{ $registrations->total() >= $exam->max_students ? 'rejected' : 'hired' }}">
                {{ $registrations->total() }} / {{ $exam->max_students }} طالب
            </span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الطالب</th>
                <th>الدولة</th>
                <th>البريد الإلكتروني</th>
                <th>رقم الهاتف</th>
                <th>الدرجة / التقييم</th>
                <th>الشهادة</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $r)
            <tr>
                <td>{{ $registrations->firstItem() + $loop->index }}</td>
                <td><strong>{{ $r->student_name }}</strong></td>
                <td>{{ $r->country }}</td>
                <td style="font-size:.85rem;">{{ $r->email }}</td>
                <td dir="ltr" style="text-align:right;">{{ $r->phone }}</td>

                {{-- Grade / Score cell --}}
                <td style="min-width:220px;">
                    <form action="{{ route('admin.exams.saveGrade', $r) }}" method="POST"
                          style="display:flex;gap:6px;align-items:center;">
                        @csrf
                        <input type="number" name="score" value="{{ $r->score }}" min="0" max="100"
                               placeholder="الدرجة" style="width:70px;padding:4px 8px;border:1px solid #ddd;border-radius:6px;text-align:center;font-size:.85rem;">
                        <select name="grade" style="padding:4px 8px;border:1px solid #ddd;border-radius:6px;font-size:.85rem;font-family:inherit;">
                            <option value="">-- التقييم --</option>
                            @foreach(['ممتاز','جيد جداً','جيد','مقبول','راسب'] as $g)
                                <option value="{{ $g }}" {{ $r->grade === $g ? 'selected' : '' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm" style="background:var(--orange);color:#fff;border:none;padding:4px 10px;border-radius:6px;cursor:pointer;" title="حفظ">
                            <i class="ph ph-floppy-disk"></i>
                        </button>
                    </form>
                </td>

                {{-- Certificate cell --}}
                <td style="min-width:130px;text-align:center;">
                    @if($r->certificate)
                        <a href="{{ route('admin.certificates.pdf', $r->certificate) }}" target="_blank"
                           class="btn btn-success btn-sm">
                            <i class="ph ph-file-pdf"></i> تحميل
                        </a>
                    @elseif($r->grade)
                        <form action="{{ route('admin.exams.issueCertificate', $r) }}" method="POST"
                              onsubmit="return confirm('إصدار شهادة لـ {{ addslashes($r->student_name) }}؟')">
                            @csrf
                            <button class="btn btn-outline btn-sm" style="border-color:var(--orange);color:var(--orange);">
                                <i class="ph ph-certificate"></i> إصدار
                            </button>
                        </form>
                    @else
                        <span style="color:var(--text-gray);font-size:.8rem;">— حدد التقييم أولاً</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:30px;color:var(--text-gray);">
                    لا يوجد طلاب مسجلون حالياً.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($registrations->hasPages())
    <div style="padding:16px 20px;">{{ $registrations->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
