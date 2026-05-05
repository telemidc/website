@extends('layouts.app')

@section('content')
<section class="section-pad" style="margin-top: 80px; min-height: 80vh; background: var(--off-white);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
            <h2 class="section-title" style="margin: 0;">لوحة التحكم - إدارة الامتحانات</h2>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.exams.create') }}" class="btn btn-primary" style="padding: 10px 20px;">+ إضافة امتحان جديد</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="color: var(--purple); border-color: var(--purple); padding: 10px 20px;">تسجيل خروج</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #dcfce7; color: #15803d; padding: 16px; border-radius: var(--radius-sm); margin-bottom: 24px; font-weight: 600;">
                {{ session('success') }}
            </div>
        @endif

        <div style="background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: right;">
                    <thead>
                        <tr style="background: var(--light-gray); border-bottom: 2px solid var(--border);">
                            <th style="padding: 16px; font-weight: 700;">اسم الدورة</th>
                            <th style="padding: 16px; font-weight: 700;">تاريخ الامتحان</th>
                            <th style="padding: 16px; font-weight: 700;">الوقت</th>
                            <th style="padding: 16px; font-weight: 700;">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $exam)
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 16px; font-weight: 600;">{{ $exam->course_name }}</td>
                            <td style="padding: 16px; color: var(--text-gray);">{{ \Carbon\Carbon::parse($exam->exam_date)->format('Y-m-d') }}</td>
                            <td style="padding: 16px; color: var(--text-gray); direction: ltr; text-align: right;">
                                {{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->end_time)->format('H:i') }}
                            </td>
                            <td style="padding: 16px; display: flex; gap: 10px;">
                                <a href="{{ route('admin.exams.edit', $exam) }}" style="color: var(--purple); text-decoration: none; font-weight: 600;">تعديل</a>
                                <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-family: inherit; font-weight: 600;">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 30px; text-align: center; color: var(--text-gray);">لا توجد امتحانات مضافة حالياً.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
