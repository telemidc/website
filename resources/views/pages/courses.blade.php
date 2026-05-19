@extends('layouts.app')

@section('content')
<section class="section-pad" style="padding-top:120px;min-height:100vh;background:var(--white);">
    <div class="container">
        <div class="public-topbar">
            <div>
                <h1 style="color:var(--purple-dark);font-size:2rem;margin-bottom:6px;">
                    <i class="ph ph-books" style="color:var(--purple);"></i>
                    {{ $locale === 'ar' ? 'جميع الدورات التدريبية' : 'All Training Courses' }}
                </h1>
                <p style="color:var(--text-gray);font-size:.95rem;">
                    {{ $locale === 'ar' ? 'تصفح الدورات المتاحة وسجل في ما يناسبك' : 'Browse available courses and register' }}
                </p>
            </div>
            <a href="{{ route('home') }}#courses" class="btn btn-outline">
                <i class="ph ph-arrow-right"></i>
                {{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}
            </a>
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('courses.page') }}" class="public-search-form">
            <div class="public-search-input-wrap">
                <i class="ph ph-magnifying-glass" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:var(--text-gray);"></i>
                <input type="text" name="q" value="{{ $search }}"
                       placeholder="{{ $locale === 'ar' ? 'بحث بالاسم أو المجال أو المدرب...' : 'Search by name, field, or instructor...' }}"
                       style="width:100%;padding:12px 40px 12px 14px;border:1.5px solid #e5e7eb;border-radius:10px;font-family:inherit;font-size:.92rem;direction:rtl;">
            </div>
            <button type="submit" class="btn btn-primary" style="background:var(--purple);padding:12px 20px;">
                {{ $locale === 'ar' ? 'بحث' : 'Search' }}
            </button>
            @if($search)
            <a href="{{ route('courses.page') }}" class="btn btn-outline" style="padding:12px 16px;">
                <i class="ph ph-x"></i>
            </a>
            @endif
        </form>

        @if($search && $courses->total() > 0)
        <p style="margin-bottom:20px;color:var(--text-gray);font-size:.9rem;">
            {{ $locale === 'ar' ? 'نتائج البحث عن' : 'Results for' }} "<strong>{{ $search }}</strong>" — {{ $courses->total() }} {{ $locale === 'ar' ? 'نتيجة' : 'results' }}
        </p>
        @endif

        @if(session('course_success'))
            <div style="background:#dcfce7;color:#15803d;padding:14px 20px;border-radius:10px;margin:0 0 20px;font-weight:600;text-align:center;">
                <i class="ph ph-check-circle"></i> {{ session('course_success') }}
            </div>
        @endif

        <!-- Courses Grid -->
        <div class="listing-grid">
            @forelse($courses as $course)
            <div class="modern-card" data-aos="fade-up">
                <div class="modern-card-header"></div>
                <div class="modern-card-body">
                    <span class="badge">{{ $course->field->name }}</span>
                    <h3>{{ $course->name }}</h3>
                    @if($course->description)
                    <p>{{ Str::limit($course->description, 120) }}</p>
                    @endif

                    <div class="modern-card-footer">
                        @if($course->teachers->count())
                        <div class="meta-item" style="margin-bottom: 12px; color: var(--purple);">
                            <i class="ph ph-chalkboard-teacher" style="color:var(--purple);"></i>
                            <strong>{{ $locale === 'ar' ? 'المدرب:' : 'Instructor:' }} {{ $course->teachers->pluck('name')->join('، ') }}</strong>
                        </div>
                        @endif

                        <div class="modern-card-meta">
                            <div class="meta-item">
                                <i class="ph ph-calendar-check"></i>
                                <span>{{ \Carbon\Carbon::parse($course->start_date)->format('d M, Y') }} &mdash; {{ \Carbon\Carbon::parse($course->end_date)->format('d M, Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="ph ph-users"></i>
                                <span>{{ $course->registrations_count }} / {{ $course->max_students }} {{ $locale === 'ar' ? 'مقعد' : 'seats' }}</span>
                            </div>
                        </div>

                        @if($course->isFull())
                            <div style="background:#fee2e2;color:#b91c1c;padding:12px;border-radius:50px;text-align:center;font-weight:700;font-size:0.95rem;">
                                {{ $locale === 'ar' ? 'اكتملت الأماكن' : 'Fully Booked' }}
                            </div>
                        @else
                            <button onclick="openCourseModal({{ $course->id }}, '{{ addslashes($course->name) }}')"
                                class="btn btn-primary" style="width:100%;">
                                <i class="ph ph-pencil-line" style="font-size:1.2rem;"></i>
                                {{ $locale === 'ar' ? 'سجل في الدورة' : 'Register' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--text-gray);">
                <i class="ph ph-books" style="font-size:3rem;display:block;margin-bottom:12px;color:#ddd;"></i>
                @if($search)
                    {{ $locale === 'ar' ? 'لا توجد نتائج للبحث' : 'No results found' }}
                @else
                    {{ $locale === 'ar' ? 'لا توجد دورات متاحة حالياً' : 'No courses available' }}
                @endif
            </div>
            @endforelse
        </div>

        @if($courses->hasPages())
        <div style="margin-top:36px;display:flex;justify-content:center;">
            {{ $courses->links() }}
        </div>
        @endif
    </div>
</section>

{{-- Course Registration Modal --}}
<div id="courseModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;align-items:center;justify-content:center;">
    <div class="modal-card">
        <h3 style="color:var(--purple-dark);margin-bottom:6px;font-size:1.2rem;" id="courseModalTitle"></h3>
        <p style="color:var(--text-gray);margin-bottom:20px;font-size:.9rem;">{{ $locale === 'ar' ? 'أدخل بياناتك للتسجيل في هذه الدورة' : 'Enter your details to register' }}</p>
        <form action="{{ route('course.register') }}" method="POST">
            @csrf
            <input type="hidden" name="course_id" id="courseId">
            <div style="margin-bottom:14px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'الاسم الكامل *' : 'Full Name *' }}</label><input type="text" name="student_name" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" required></div>
            <div style="margin-bottom:14px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'الدولة *' : 'Country *' }}</label><input type="text" name="country" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" required></div>
            <div style="margin-bottom:14px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'البريد الإلكتروني *' : 'Email *' }}</label><input type="email" name="email" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" dir="ltr" required></div>
            <div style="margin-bottom:20px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'رقم الهاتف (واتساب) *' : 'WhatsApp *' }}</label><input type="text" name="phone" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" dir="ltr" required></div>
            <div class="modal-actions">
                <button type="button" onclick="closeCourseModal()" style="flex:1;padding:11px;border:1.5px solid #e5e7eb;border-radius:8px;background:transparent;cursor:pointer;font-family:inherit;font-size:.9rem;">{{ $locale === 'ar' ? 'إلغاء' : 'Cancel' }}</button>
                <button type="submit" class="btn btn-primary" style="flex:2;justify-content:center;background:var(--purple);">{{ $locale === 'ar' ? 'تأكيد التسجيل' : 'Confirm' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openCourseModal(id, name) {
    document.getElementById('courseId').value = id;
    document.getElementById('courseModalTitle').textContent = name;
    document.getElementById('courseModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeCourseModal() {
    document.getElementById('courseModal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('courseModal')?.addEventListener('click', function(e) { if(e.target === this) closeCourseModal(); });
</script>
@endpush
