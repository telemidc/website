@extends('layouts.admin')
@section('title', 'الشهادات')
@section('content')

<div class="card">
    <div class="card-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
        <h3><i class="ph ph-certificate" style="color:var(--orange)"></i> الشهادات الصادرة</h3>

        <form method="GET" action="{{ route('admin.certificates.index') }}"
              style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <div style="position:relative;">
                <i class="ph ph-magnifying-glass"
                   style="position:absolute; right:10px; top:50%; transform:translateY(-50%); color:var(--text-gray); pointer-events:none;"></i>
                <input type="text" name="q" value="{{ $query }}"
                       placeholder="بحث باسم الطالب أو رقم الشهادة..."
                       style="padding:8px 36px 8px 12px; border:1px solid #ddd; border-radius:8px;
                              font-family:inherit; font-size:.9rem; width:280px; direction:rtl;">
            </div>
            <button type="submit" class="btn btn-sm" style="background:var(--orange);color:#fff;border:none;padding:8px 16px;border-radius:8px;cursor:pointer;">
                بحث
            </button>
            @if($query)
            <a href="{{ route('admin.certificates.index') }}"
               style="padding:8px 12px; border-radius:8px; border:1px solid #ddd; color:var(--text-gray); font-size:.85rem; text-decoration:none;">
                <i class="ph ph-x"></i> مسح
            </a>
            @endif
        </form>
    </div>

    @if($query)
    <div style="padding:10px 20px; background:var(--off-white); border-bottom:1px solid #eee; font-size:.9rem; color:var(--text-gray);">
        <i class="ph ph-funnel"></i>
        نتائج البحث عن "<strong style="color:var(--dark);">{{ $query }}</strong>":
        <strong style="color:var(--orange);">{{ $certificates->total() }}</strong> نتيجة
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>رقم الشهادة</th>
                <th>اسم الطالب</th>
                <th>الدورة</th>
                <th>التقييم</th>
                <th>تاريخ الإصدار</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($certificates as $cert)
            <tr>
                <td>
                    <code style="background:var(--off-white);padding:3px 8px;border-radius:4px;font-size:.8rem;">
                        {{ $cert->certificate_number }}
                    </code>
                </td>
                <td><strong>{{ $cert->registration->student_name }}</strong></td>
                <td>{{ $cert->registration->course->name }}</td>
                <td><span class="badge badge-hired">{{ $cert->grade }}</span></td>
                <td>{{ \Carbon\Carbon::parse($cert->issued_at)->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.certificates.pdf', $cert) }}" target="_blank"
                       class="btn btn-success btn-sm">
                        <i class="ph ph-file-pdf"></i> تحميل PDF
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:30px;color:var(--text-gray);">
                    @if($query)
                        <i class="ph ph-magnifying-glass" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>
                        لا توجد نتائج للبحث عن "<strong>{{ $query }}</strong>"
                    @else
                        لا توجد شهادات صادرة بعد. اذهب إلى قائمة الدورات واختر طالباً لإصدار شهادة.
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($certificates->hasPages())
    <div style="padding:16px 20px; border-top:1px solid #eee;">
        {{ $certificates->links() }}
    </div>
    @endif
</div>
@endsection
