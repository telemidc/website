@extends('layouts.admin')
@section('title', 'نتائج الامتحانات المنجزة')
@section('content')

<div style="margin-bottom:20px;">
    <a href="{{ route('admin.exams.index') }}" class="btn btn-outline">
        <i class="ph ph-arrow-right"></i> العودة للامتحانات
    </a>
</div>

{{-- ─── Search Panel ─── --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-header">
        <h3><i class="ph ph-chart-bar" style="color:var(--orange)"></i> نتائج الامتحانات المنجزة</h3>
    </div>
    <div style="padding:20px;">
        <form method="GET" action="{{ route('admin.exams.results') }}"
              style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">

            <div style="flex:1;min-width:220px;">
                <label style="display:block;font-weight:600;margin-bottom:6px;font-size:.9rem;">اختر الامتحان</label>
                <select name="exam_id" class="form-control" style="font-family:inherit;" required>
                    <option value="">-- اختر امتحاناً منجزاً --</option>
                    @foreach($exams as $e)
                        <option value="{{ $e->id }}"
                            {{ (string)request('exam_id') === (string)$e->id ? 'selected' : '' }}>
                            {{ $e->subject->field->name ?? '' }} — {{ $e->subject->name }}
                            ({{ \Carbon\Carbon::parse($e->exam_date)->format('Y-m-d') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="min-width:200px;">
                <label style="display:block;font-weight:600;margin-bottom:6px;font-size:.9rem;">بحث باسم الطالب / الهاتف</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="اسم الطالب أو رقم الهاتف..."
                       class="form-control" style="font-family:inherit;">
            </div>

            <div style="display:flex;gap:8px;align-items:flex-end;padding-bottom:1px;">
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-magnifying-glass"></i> بحث
                </button>
                @if(request('exam_id'))
                <a href="{{ route('admin.exams.results') }}" class="btn btn-outline">
                    <i class="ph ph-x"></i> مسح
                </a>
                @endif
            </div>
        </form>

        @if($exams->isEmpty())
        <div style="margin-top:16px;padding:12px 16px;background:#fff3cd;border-radius:8px;color:#856404;font-size:.9rem;">
            <i class="ph ph-warning"></i>
            لا توجد امتحانات منجزة بعد. قم بتغيير حالة الامتحان إلى "منجز" من صفحة الامتحانات.
        </div>
        @endif
    </div>
</div>

{{-- ─── Results Table ─── --}}
@if($selectedExam)
<div class="card">
    <div class="card-header">
        <div>
            <h3 style="margin-bottom:4px;">
                <i class="ph ph-users" style="color:var(--orange)"></i>
                {{ $selectedExam->subject->name }}
                <small style="color:var(--text-gray);font-weight:400;font-size:.85rem;">
                    — {{ \Carbon\Carbon::parse($selectedExam->exam_date)->format('Y-m-d') }}
                    | {{ \Carbon\Carbon::parse($selectedExam->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($selectedExam->end_time)->format('H:i') }}
                </small>
            </h3>
            <div style="font-size:.85rem;color:var(--text-gray);">
                المجال: {{ $selectedExam->subject->field->name ?? '-' }}
                &nbsp;|&nbsp;
                إجمالي المسجلين: <strong>{{ $registrations->total() }}</strong>
            </div>
        </div>
        {{-- Quick stats --}}
        @php
            $graded = $registrations->getCollection()->whereNotNull('grade')->count();
            $certified = $registrations->getCollection()->filter(fn($r) => $r->certificate)->count();
        @endphp
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <div style="text-align:center;padding:8px 16px;background:var(--off-white);border-radius:8px;">
                <div style="font-size:1.2rem;font-weight:700;color:var(--orange);">{{ $registrations->total() }}</div>
                <div style="font-size:.75rem;color:var(--text-gray);">إجمالي</div>
            </div>
            <div style="text-align:center;padding:8px 16px;background:var(--off-white);border-radius:8px;">
                <div style="font-size:1.2rem;font-weight:700;color:#198754;">{{ $graded }}</div>
                <div style="font-size:.75rem;color:var(--text-gray);">مقيَّم</div>
            </div>
            <div style="text-align:center;padding:8px 16px;background:var(--off-white);border-radius:8px;">
                <div style="font-size:1.2rem;font-weight:700;color:#2d1b69;">{{ $certified }}</div>
                <div style="font-size:.75rem;color:var(--text-gray);">شهادات</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الطالب</th>
                <th>الدولة</th>
                <th>البريد الإلكتروني</th>
                <th>الهاتف</th>
                <th>الدرجة</th>
                <th>التقييم</th>
                <th>الشهادة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $r)
            <tr>
                <td>{{ $registrations->firstItem() + $loop->index }}</td>
                <td><strong>{{ $r->student_name }}</strong></td>
                <td>{{ $r->country }}</td>
                <td style="font-size:.82rem;">{{ $r->email }}</td>
                <td dir="ltr" style="text-align:right;">{{ $r->phone }}</td>
                <td style="text-align:center;">
                    @if($r->score !== null)
                        <strong style="font-size:1rem;">{{ $r->score }}</strong><span style="font-size:.75rem;color:var(--text-gray)">/100</span>
                    @else
                        <span style="color:#bbb;">—</span>
                    @endif
                </td>
                <td style="text-align:center;">
                    @if($r->grade)
                        @php
                            $badgeColor = match($r->grade) {
                                'ممتاز'    => '#198754',
                                'جيد جداً' => '#0d6efd',
                                'جيد'      => '#0dcaf0',
                                'مقبول'    => '#ffc107',
                                'راسب'     => '#dc3545',
                                default    => '#6c757d',
                            };
                        @endphp
                        <span style="background:{{ $badgeColor }};color:#fff;padding:3px 10px;border-radius:12px;font-size:.82rem;">
                            {{ $r->grade }}
                        </span>
                    @else
                        <span style="color:#bbb;font-size:.82rem;">لم يُقيَّم</span>
                    @endif
                </td>
                <td style="text-align:center;">
                    @if($r->certificate)
                        <a href="{{ route('admin.certificates.pdf', $r->certificate) }}" target="_blank"
                           class="btn btn-success btn-sm">
                            <i class="ph ph-file-pdf"></i> تحميل
                        </a>
                    @else
                        <span style="color:#bbb;font-size:.8rem;">—</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                        {{-- Inline grade form --}}
                        <form action="{{ route('admin.exams.saveGrade', $r) }}" method="POST"
                              style="display:flex;gap:4px;align-items:center;">
                            @csrf
                            <input type="number" name="score" value="{{ $r->score }}" min="0" max="100"
                                   placeholder="درجة" style="width:60px;padding:3px 6px;border:1px solid #ddd;border-radius:6px;text-align:center;font-size:.82rem;">
                            <select name="grade" style="padding:3px 6px;border:1px solid #ddd;border-radius:6px;font-size:.82rem;font-family:inherit;">
                                <option value="">تقييم</option>
                                @foreach(['ممتاز','جيد جداً','جيد','مقبول','راسب'] as $g)
                                    <option value="{{ $g }}" {{ $r->grade === $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm"
                                    style="background:var(--orange);color:#fff;border:none;padding:3px 8px;border-radius:6px;" title="حفظ">
                                <i class="ph ph-floppy-disk"></i>
                            </button>
                        </form>

                        {{-- Issue certificate --}}
                        @if(!$r->certificate && $r->grade)
                        <form action="{{ route('admin.exams.issueCertificate', $r) }}" method="POST"
                              onsubmit="return confirm('إصدار شهادة لـ {{ addslashes($r->student_name) }}؟')">
                            @csrf
                            <button class="btn btn-outline btn-sm"
                                    style="border-color:var(--orange);color:var(--orange);padding:3px 8px;">
                                <i class="ph ph-certificate"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;padding:30px;color:var(--text-gray);">
                    <i class="ph ph-magnifying-glass" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>
                    لا توجد نتائج.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($registrations->hasPages())
    <div style="padding:16px 20px;">{{ $registrations->links() }}</div>
    @endif
</div>
@endif

@endsection
