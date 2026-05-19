@extends('layouts.admin')
@section('title', 'لوحة التحكم')
@section('content')

<div class="stats-grid">
    <div class="stat-card">
        <div class="icon" style="background:#fff3e0;color:var(--orange)"><i class="ph ph-exam"></i></div>
        <div class="info"><h3>{{ $stats['upcoming_exams'] }}</h3><p>امتحانات قادمة</p></div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:#ede9fe;color:var(--purple)"><i class="ph ph-users"></i></div>
        <div class="info"><h3>{{ $stats['exam_registrations'] }}</h3><p>تسجيلات امتحانات</p></div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:#dcfce7;color:#15803d"><i class="ph ph-chalkboard-teacher"></i></div>
        <div class="info"><h3>{{ $stats['courses'] }}</h3><p>دورات</p></div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:#dbeafe;color:#1e40af"><i class="ph ph-student"></i></div>
        <div class="info"><h3>{{ $stats['course_registrations'] }}</h3><p>تسجيلات دورات</p></div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:#fef9c3;color:#854d0e"><i class="ph ph-user-check"></i></div>
        <div class="info"><h3>{{ $stats['teacher_applications'] }}</h3><p>طلبات أساتذة معلقة</p></div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:#fee2e2;color:#b91c1c"><i class="ph ph-certificate"></i></div>
        <div class="info"><h3>{{ $stats['certificates'] }}</h3><p>شهادات صادرة</p></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;flex-wrap:wrap;">
    <div class="card">
        <div class="card-header"><h3><i class="ph ph-clock" style="color:var(--orange)"></i> آخر تسجيلات الامتحانات</h3></div>
        <table>
            <thead><tr><th>الطالب</th><th>الامتحان</th><th>التاريخ</th></tr></thead>
            <tbody>
                @forelse($latest_exam_regs as $r)
                <tr>
                    <td><strong>{{ $r->student_name }}</strong><br><small style="color:var(--text-gray)">{{ $r->country }}</small></td>
                    <td>{{ $r->exam->subject->name ?? '-' }}</td>
                    <td>{{ $r->created_at->format('Y-m-d') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--text-gray);padding:20px;">لا توجد تسجيلات بعد</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-header"><h3><i class="ph ph-user-plus" style="color:var(--purple)"></i> آخر طلبات الأساتذة</h3></div>
        <table>
            <thead><tr><th>الاسم</th><th>المجال</th><th>الحالة</th></tr></thead>
            <tbody>
                @forelse($latest_teachers as $t)
                <tr>
                    <td><strong>{{ $t->name }}</strong></td>
                    <td>{{ $t->field->name ?? '-' }}</td>
                    <td><span class="badge badge-{{ $t->status }}">{{ $t->status === 'pending' ? 'معلق' : ($t->status === 'hired' ? 'موظف' : 'مرفوض') }}</span></td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--text-gray);padding:20px;">لا توجد طلبات بعد</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
