@extends('layouts.admin')
@section('title', 'التقارير والإحصائيات الشاملة')
@section('content')

<div class="card" style="background: linear-gradient(135deg, var(--purple-dark) 0%, var(--purple) 100%); color: #fff; border: none;">
    <div class="card-body" style="padding: 30px;">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:20px;">
            <div>
                <h2 style="font-size:1.6rem;font-weight:800;margin-bottom:8px;"><i class="ph ph-chart-pie-slice"></i> استخراج التقارير الذكية</h2>
                <p style="color:rgba(255,255,255,0.7);font-size:.95rem;">قم بتحديد الفترة الزمنية ونوع التقرير المطلوب لتوليد إحصائيات دقيقة أو طباعتها كملف PDF.</p>
            </div>
            <a href="{{ route('admin.reports.pdf') }}?start_date={{ $startDate }}&end_date={{ $endDate }}&type={{ $type }}" class="btn" style="background:#fff;color:var(--purple-dark);padding:12px 24px;border-radius:30px;box-shadow:0 10px 25px rgba(0,0,0,0.2);" target="_blank">
                <i class="ph ph-file-pdf" style="color:var(--orange);font-size:1.3rem;"></i> طباعة التقرير PDF
            </a>
        </div>

        <form method="GET" action="{{ route('admin.reports.index') }}" style="margin-top:30px;background:rgba(0,0,0,0.2);padding:20px;border-radius:16px;border:1px solid rgba(255,255,255,0.1);display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;align-items:end;">
            <div>
                <label style="display:block;font-size:.85rem;margin-bottom:6px;color:rgba(255,255,255,0.8);">من تاريخ</label>
                <input type="date" name="start_date" value="{{ $startDate }}" style="width:100%;padding:10px 14px;border-radius:10px;border:none;background:rgba(255,255,255,0.9);font-family:inherit;">
            </div>
            <div>
                <label style="display:block;font-size:.85rem;margin-bottom:6px;color:rgba(255,255,255,0.8);">إلى تاريخ</label>
                <input type="date" name="end_date" value="{{ $endDate }}" style="width:100%;padding:10px 14px;border-radius:10px;border:none;background:rgba(255,255,255,0.9);font-family:inherit;">
            </div>
            <div>
                <label style="display:block;font-size:.85rem;margin-bottom:6px;color:rgba(255,255,255,0.8);">نوع التقرير</label>
                <select name="type" style="width:100%;padding:10px 14px;border-radius:10px;border:none;background:rgba(255,255,255,0.9);font-family:inherit;">
                    <option value="all" {{ $type == 'all' ? 'selected' : '' }}>التقرير الشامل (الكل)</option>
                    <option value="detailed" {{ $type == 'detailed' ? 'selected' : '' }}>التقارير التفصيلية (جداول البيانات)</option>
                    <option value="students" {{ $type == 'students' ? 'selected' : '' }}>تقرير الطلاب والتسجيلات</option>
                    <option value="certificates" {{ $type == 'certificates' ? 'selected' : '' }}>تقرير الشهادات المصدرة</option>
                    <option value="teachers" {{ $type == 'teachers' ? 'selected' : '' }}>تقرير الموارد البشرية والأساتذة</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" style="width:100%;height:42px;justify-content:center;border-radius:10px;"><i class="ph ph-funnel"></i> تصفية واستعراض</button>
            </div>
        </form>
    </div>
</div>

<h3 style="margin-bottom:20px;font-weight:800;color:var(--text-dark);">
    نتائج التقرير 
    <small style="color:var(--orange);font-size:1rem;margin-right:10px;">(من {{ $startDate }} إلى {{ $endDate }})</small>
</h3>

<div class="stats-grid">
    @if(in_array($type, ['all', 'students']))
    <div class="stat-card" style="border-right: 4px solid var(--orange);">
        <div class="icon" style="background:rgba(241,90,36,0.1);color:var(--orange);"><i class="ph ph-users"></i></div>
        <div class="info">
            <p>تسجيلات الدورات</p>
            <h3>{{ $data['course_students'] }}</h3>
        </div>
    </div>
    <div class="stat-card" style="border-right: 4px solid #3b82f6;">
        <div class="icon" style="background:rgba(59,130,246,0.1);color:#3b82f6;"><i class="ph ph-exam"></i></div>
        <div class="info">
            <p>تسجيلات الامتحانات</p>
            <h3>{{ $data['exam_students'] }}</h3>
        </div>
    </div>
    @endif

    @if(in_array($type, ['all', 'certificates']))
    <div class="stat-card" style="border-right: 4px solid #10b981;">
        <div class="icon" style="background:rgba(16,185,129,0.1);color:#10b981;"><i class="ph ph-certificate"></i></div>
        <div class="info">
            <p>الشهادات المصدرة</p>
            <h3>{{ $data['certificates'] }}</h3>
        </div>
    </div>
    @endif

    @if(in_array($type, ['all', 'teachers']))
    <div class="stat-card" style="border-right: 4px solid var(--purple);">
        <div class="icon" style="background:rgba(75,41,145,0.1);color:var(--purple);"><i class="ph ph-chalkboard-teacher"></i></div>
        <div class="info">
            <p>طلبات الأساتذة</p>
            <h3>{{ $data['teachers_total'] }}</h3>
        </div>
    </div>
    <div class="stat-card" style="border-right: 4px solid #f59e0b;">
        <div class="icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;"><i class="ph ph-handshake"></i></div>
        <div class="info">
            <p>الأساتذة الموظفين</p>
            <h3>{{ $data['teachers_hired'] }}</h3>
        </div>
    </div>
    <div class="stat-card" style="border-right: 4px solid #ef4444;">
        <div class="icon" style="background:rgba(239,68,68,0.1);color:#ef4444;"><i class="ph ph-currency-dollar"></i></div>
        <div class="info">
            <p>إجمالي الرواتب ($)</p>
            <h3>{{ number_format($data['teachers_salaries'], 2) }}</h3>
        </div>
    </div>
    @endif
</div>

@if(in_array($type, ['all', 'students']) && ($data['course_students'] > 0 || $data['exam_students'] > 0))
<div class="form-grid">
    <div class="card">
        <div class="card-header">
            <h3><i class="ph ph-clock-counter-clockwise"></i> أحدث تسجيلات الدورات</h3>
        </div>
        <table>
            <thead><tr><th>اسم الطالب</th><th>الدورة</th><th>التاريخ</th></tr></thead>
            <tbody>
                @forelse($data['recent_courses'] as $cr)
                <tr>
                    <td><strong>{{ $cr->student_name }}</strong></td>
                    <td>{{ $cr->course->name }}</td>
                    <td>{{ $cr->created_at->format('Y-m-d') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;padding:10px;color:var(--text-gray);">لا يوجد تسجيلات حديثة.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-header">
            <h3><i class="ph ph-clock-counter-clockwise"></i> أحدث تسجيلات الامتحانات</h3>
        </div>
        <table>
            <thead><tr><th>اسم الطالب</th><th>الامتحان (المادة)</th><th>التاريخ</th></tr></thead>
            <tbody>
                @forelse($data['recent_exams'] as $er)
                <tr>
                    <td><strong>{{ $er->student_name }}</strong></td>
                    <td>{{ $er->exam->subject->name }}</td>
                    <td>{{ $er->created_at->format('Y-m-d') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;padding:10px;color:var(--text-gray);">لا يوجد تسجيلات حديثة.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

@if($type === 'detailed')
<div class="card">
    <div class="card-header">
        <h3><i class="ph ph-table"></i> التفاصيل الكاملة لتسجيلات الدورات</h3>
    </div>
    <table>
        <thead><tr><th>اسم الطالب</th><th>رقم الهاتف</th><th>الدورة</th><th>التاريخ</th></tr></thead>
        <tbody>
            @forelse($data['detailed_courses'] ?? [] as $cr)
            <tr>
                <td><strong>{{ $cr->student_name }}</strong></td>
                <td><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cr->phone) }}" target="_blank" style="color:var(--orange);text-decoration:none;">{{ $cr->phone }}</a></td>
                <td>{{ $cr->course->name }}</td>
                <td>{{ $cr->created_at->format('Y-m-d') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;padding:10px;color:var(--text-gray);">لا يوجد بيانات تفصيلية.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="ph ph-table"></i> التفاصيل الكاملة لتسجيلات الامتحانات</h3>
    </div>
    <table>
        <thead><tr><th>اسم الطالب</th><th>رقم الهاتف</th><th>الامتحان (المادة)</th><th>التاريخ</th></tr></thead>
        <tbody>
            @forelse($data['detailed_exams'] ?? [] as $er)
            <tr>
                <td><strong>{{ $er->student_name }}</strong></td>
                <td><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $er->phone) }}" target="_blank" style="color:var(--orange);text-decoration:none;">{{ $er->phone }}</a></td>
                <td>{{ $er->exam->subject->name }}</td>
                <td>{{ $er->created_at->format('Y-m-d') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;padding:10px;color:var(--text-gray);">لا يوجد بيانات تفصيلية.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="ph ph-table"></i> التفاصيل الكاملة للأساتذة الموظفين</h3>
    </div>
    <table>
        <thead><tr><th>الاسم</th><th>رقم الهاتف</th><th>المجال</th><th>تاريخ التوظيف</th></tr></thead>
        <tbody>
            @forelse($data['detailed_teachers'] ?? [] as $tr)
            <tr>
                <td><strong>{{ $tr->full_name }}</strong></td>
                <td><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tr->phone) }}" target="_blank" style="color:var(--orange);text-decoration:none;">{{ $tr->phone }}</a></td>
                <td>{{ $tr->field->name }}</td>
                <td>{{ $tr->created_at->format('Y-m-d') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;padding:10px;color:var(--text-gray);">لا يوجد بيانات تفصيلية.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endif

@endsection
