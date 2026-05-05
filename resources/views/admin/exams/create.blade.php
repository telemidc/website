@extends('layouts.app')

@section('content')
<section class="section-pad" style="margin-top: 80px; min-height: 80vh; background: var(--off-white);">
    <div class="container" style="max-width: 600px;">
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
            <h2 class="section-title" style="margin: 0;">إضافة امتحان جديد</h2>
            <a href="{{ route('admin.exams.index') }}" class="btn btn-outline" style="color: var(--purple); border-color: var(--purple); padding: 8px 16px;">العودة للوحة التحكم</a>
        </div>

        <div style="background: var(--white); padding: 40px; border-radius: var(--radius); box-shadow: var(--shadow);">
            
            @if ($errors->any())
                <div style="background: #fee2e2; color: #b91c1c; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 0.9rem;">
                    <ul style="margin: 0; padding-right: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.exams.store') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">اسم الدورة</label>
                    <input type="text" name="course_name" value="{{ old('course_name') }}" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 1rem;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">تاريخ الامتحان</label>
                    <input type="date" name="exam_date" value="{{ old('exam_date') }}" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 1rem;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">وقت البداية</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 1rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">وقت النهاية</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 1rem;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
                    حفظ وإضافة
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
