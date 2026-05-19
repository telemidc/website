@extends('layouts.app')

@section('content')

<!-- ===== HERO ===== -->
<section class="hero" id="home">
    <div class="hero-bg-shapes">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
        <div class="hero-shape hero-shape-3"></div>
    </div>

    <div class="container" style="width:100%;">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                {{ $locale === 'ar' ? 'بنغازي - ليبيا' : 'Benghazi - Libya' }}
            </div>

            <h1>{{ __('hero.title') }}</h1>
            @if($locale === 'ar')
                <span class="hero-title-ar">Resources of Development</span>
            @else
                <span class="hero-title-ar">مصادر التنمية</span>
            @endif

            <p class="hero-sub">{{ __('hero.subtitle') }}</p>

            <div class="hero-cta-group">
                <a href="#contact" class="btn btn-primary">
                    <i class="ph ph-phone"></i>
                    {{ __('hero.cta') }}
                </a>
                <a href="#about" class="btn btn-outline">
                    {{ __('hero.discover') }}
                    <i class="ph ph-arrow-{{ $locale === 'ar' ? 'left' : 'right' }}"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="hero-scroll">
        <div class="scroll-wheel"></div>
    </div>
</section>

<!-- ===== ABOUT ===== -->
<section class="about section-pad" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-image-wrap" data-aos="fade-{{ $locale === 'ar' ? 'left' : 'right' }}">
                <div class="about-logo-box">
                    <img src="{{ asset('assets/logo.png') }}" alt="{{ __('hero.title') }}">
                </div>
                <div class="about-badge">
                    +10
                    <span>{{ $locale === 'ar' ? 'سنوات خبرة' : 'Years of Experience' }}</span>
                </div>
            </div>

            <div class="about-text" data-aos="fade-{{ $locale === 'ar' ? 'right' : 'left' }}" data-aos-delay="100">
                <span class="section-label">{{ __('about.subtitle') }}</span>
                <h2>{{ __('about.title') }}</h2>
                <p>{{ __('about.desc') }}</p>

                <div class="accred-cards">
                    <div class="accred-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="accred-icon"><i class="ph ph-graduation-cap" style="font-size:2rem;color:var(--orange);"></i></div>
                        <h4>{{ __('about.accred_title') }}</h4>
                        <p>{{ __('about.accred_desc') }}</p>
                    </div>
                    <div class="accred-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="accred-icon"><i class="ph ph-seal-check" style="font-size:2rem;color:var(--orange);"></i></div>
                        <h4>{{ __('about.iso_title') }}</h4>
                        <p>{{ __('about.iso_desc') }}</p>
                    </div>
                </div>

                <!-- Approvals Gallery -->
                <div class="approvals-gallery" style="display: flex; gap: 16px; margin-top: 30px; align-items: center; justify-content: flex-start; flex-wrap: wrap;">
                    <img src="{{ asset('assets/approval.png') }}" alt="Approval" style="height: 70px; object-fit: contain; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));" data-aos="zoom-in" data-aos-delay="400">
                    <img src="{{ asset('assets/approval2.png') }}" alt="Approval 2" style="height: 70px; object-fit: contain; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));" data-aos="zoom-in" data-aos-delay="500">
                    <img src="{{ asset('assets/approval3.png') }}" alt="Approval 3" style="height: 70px; object-fit: contain; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));" data-aos="zoom-in" data-aos-delay="600">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== SERVICES ===== -->
<section class="services section-pad" id="services">
    <div class="container">
        <div class="text-center">
            <span class="section-label">{{ __('services.subtitle') }}</span>
            <h2 class="section-title">{{ __('services.title') }}</h2>
        </div>

        <div class="services-grid">
            <div class="service-card" data-aos="fade-up" data-aos-delay="0">
                <div class="service-icon-wrap"><i class="ph ph-graduation-cap" style="font-size:2.2rem;"></i></div>
                <h3>{{ __('services.s1_title') }}</h3>
                <p>{{ __('services.s1_desc') }}</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="80">
                <div class="service-icon-wrap"><i class="ph ph-trophy" style="font-size:2.2rem;"></i></div>
                <h3>{{ __('services.s2_title') }}</h3>
                <p>{{ __('services.s2_desc') }}</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="160">
                <div class="service-icon-wrap"><i class="ph ph-lightbulb" style="font-size:2.2rem;"></i></div>
                <h3>{{ __('services.s3_title') }}</h3>
                <p>{{ __('services.s3_desc') }}</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="240">
                <div class="service-icon-wrap"><i class="ph ph-certificate" style="font-size:2.2rem;"></i></div>
                <h3>{{ __('services.s4_title') }}</h3>
                <p>{{ __('services.s4_desc') }}</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="320">
                <div class="service-icon-wrap"><i class="ph ph-gear" style="font-size:2.2rem;"></i></div>
                <h3>{{ __('services.s5_title') }}</h3>
                <p>{{ __('services.s5_desc') }}</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                <div class="service-icon-wrap"><i class="ph ph-globe" style="font-size:2.2rem;"></i></div>
                <h3>{{ __('services.s6_title') }}</h3>
                <p>{{ __('services.s6_desc') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== STATS ===== -->
<section class="stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item" data-aos="zoom-in" data-aos-delay="0">
                <span class="stat-icon" style="color: var(--orange-light); font-size: 2.5rem;"><i class="ph ph-books"></i></span>
                <span class="stat-number" data-target="30">0</span>
                <span class="stat-label">{{ __('stats.courses') }}</span>
            </div>
            <div class="stat-item" data-aos="zoom-in" data-aos-delay="100">
                <span class="stat-icon" style="color: var(--orange-light); font-size: 2.5rem;"><i class="ph ph-users-three"></i></span>
                <span class="stat-number" data-target="571">0</span>
                <span class="stat-label">{{ __('stats.trainees') }}</span>
            </div>
            <div class="stat-item" data-aos="zoom-in" data-aos-delay="200">
                <span class="stat-icon" style="color: var(--orange-light); font-size: 2.5rem;"><i class="ph ph-chalkboard-teacher"></i></span>
                <span class="stat-number" data-target="36">0</span>
                <span class="stat-label">{{ __('stats.experts') }}</span>
            </div>
            <div class="stat-item" data-aos="zoom-in" data-aos-delay="300">
                <span class="stat-icon" style="color: var(--orange-light); font-size: 2.5rem;"><i class="ph ph-globe-hemisphere-west"></i></span>
                <span class="stat-number" data-target="9">0</span>
                <span class="stat-label">{{ __('stats.countries') }}</span>
            </div>
        </div>
    </div>
</section>

<!-- ===== INTERNATIONAL PARTNERS ===== -->
<section class="section-pad" id="partners" style="background:var(--white);">
    <div class="container">
        <div class="text-center">
            <span class="section-label" data-aos="fade-up">{{ $locale === 'ar' ? 'اعتمادات وشراكات' : 'Accreditations & Partnerships' }}</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">{{ $locale === 'ar' ? 'شركاؤنا الدوليين' : 'Our International Partners' }}</h2>
        </div>

        <div class="partners-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:22px;margin-top:45px;align-items:center;">
            <div class="partner-card" data-aos="fade-up" data-aos-delay="0" style="background:#fff;border:1px solid rgba(85,48,129,.08);border-radius:18px;padding:24px;min-height:140px;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 30px rgba(15,23,42,.06);">
                <img src="{{ asset('assets/partner-oet.png') }}" alt="OET Occupational English Test" style="width:100%;max-height:88px;object-fit:contain;">
            </div>
            <div class="partner-card" data-aos="fade-up" data-aos-delay="80" style="background:#fff;border:1px solid rgba(85,48,129,.08);border-radius:18px;padding:24px;min-height:140px;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 30px rgba(15,23,42,.06);">
                <img src="{{ asset('assets/partner-pearson.png') }}" alt="Pearson" style="width:100%;max-height:88px;object-fit:contain;">
            </div>
            <div class="partner-card" data-aos="fade-up" data-aos-delay="160" style="background:#fff;border:1px solid rgba(85,48,129,.08);border-radius:18px;padding:24px;min-height:140px;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 30px rgba(15,23,42,.06);">
                <img src="{{ asset('assets/partner-pmi.png') }}" alt="Project Management Institute" style="width:100%;max-height:88px;object-fit:contain;">
            </div>
            <div class="partner-card" data-aos="fade-up" data-aos-delay="240" style="background:#fff;border:1px solid rgba(85,48,129,.08);border-radius:18px;padding:24px;min-height:140px;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 30px rgba(15,23,42,.06);">
                <img src="{{ asset('assets/partner-cisco.png') }}" alt="Cisco" style="width:100%;max-height:88px;object-fit:contain;">
            </div>
            <div class="partner-card" data-aos="fade-up" data-aos-delay="320" style="background:#fff;border:1px solid rgba(85,48,129,.08);border-radius:18px;padding:24px;min-height:140px;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 30px rgba(15,23,42,.06);">
                <img src="{{ asset('assets/partner-pmp.png') }}" alt="PMI PMP" style="width:100%;max-height:88px;object-fit:contain;">
            </div>
        </div>
    </div>
</section>

<!-- ===== COURSES (first 4) ===== -->
@if(isset($courses) && $courses->count() > 0)
<section class="section-pad" id="courses" style="background:var(--white);">
    <div class="container">
        <div class="text-center">
            <span class="section-label" data-aos="fade-up">{{ $locale === 'ar' ? 'دورات متاحة' : 'Available Courses' }}</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">{{ $locale === 'ar' ? 'الدورات التدريبية' : 'Training Courses' }}</h2>
        </div>

        @if(session('course_success'))
            <div style="background:#dcfce7;color:#15803d;padding:14px 20px;border-radius:10px;margin:20px 0;font-weight:600;text-align:center;">
                <i class="ph ph-check-circle"></i> {{ session('course_success') }}
            </div>
        @endif
        @if(session('course_error'))
            <div style="background:#fee2e2;color:#b91c1c;padding:14px 20px;border-radius:10px;margin:20px 0;font-weight:600;text-align:center;">
                <i class="ph ph-warning-circle"></i> {{ session('course_error') }}
            </div>
        @endif

        <div class="listing-grid" style="margin-top:50px;">
            @foreach($courses->take(4) as $course)
            <div class="modern-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="modern-card-header"></div>
                <div class="modern-card-body">
                    <span class="badge">{{ $course->field->name }}</span>
                    <h3>{{ $course->name }}</h3>
                    @if($course->description)
                    <p>{{ Str::limit($course->description, 100) }}</p>
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
                                {{ $locale === 'ar' ? 'سجل في الدورة' : 'Register for Course' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($courses->count() > 4)
        <div class="text-center" style="margin-top:50px;" data-aos="fade-up">
            <a href="{{ route('courses.page') }}" class="btn btn-outline" style="color:var(--purple); border-color:var(--purple);">
                {{ $locale === 'ar' ? 'عرض جميع الدورات' : 'View All Courses' }}
                <i class="ph ph-arrow-{{ $locale === 'ar' ? 'left' : 'right' }}"></i>
            </a>
        </div>
        @endif
    </div>
</section>
@endif

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
            <div style="margin-bottom:20px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'رقم الهاتف (واتساب) *' : 'WhatsApp Number *' }}</label><input type="text" name="phone" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" dir="ltr" required></div>
            <div class="modal-actions">
                <button type="button" onclick="closeCourseModal()" style="flex:1;padding:11px;border:1.5px solid #e5e7eb;border-radius:8px;background:transparent;cursor:pointer;font-family:inherit;font-size:.9rem;">{{ $locale === 'ar' ? 'إلغاء' : 'Cancel' }}</button>
                <button type="submit" class="btn btn-primary" style="flex:2;justify-content:center;background:var(--purple);">{{ $locale === 'ar' ? 'تأكيد التسجيل' : 'Confirm' }}</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== EXAMS (first 4) ===== -->
@if(isset($exams) && $exams->count() > 0)
<section class="exams section-pad" id="exams" style="background: var(--off-white);">
    <div class="container">
        <div class="text-center">
            <span class="section-label" data-aos="fade-up">{{ $locale === 'ar' ? 'التسجيل مفتوح' : 'Registration Open' }}</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">{{ $locale === 'ar' ? 'مواعيد الامتحانات القادمة' : 'Upcoming Exams' }}</h2>
        </div>

        @if(session('success'))
            <div style="background:#dcfce7;color:#15803d;padding:14px 20px;border-radius:10px;margin:20px 0;font-weight:600;text-align:center;">
                <i class="ph ph-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#fee2e2;color:#b91c1c;padding:14px 20px;border-radius:10px;margin:20px 0;font-weight:600;text-align:center;">
                <i class="ph ph-warning-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="listing-grid" style="margin-top: 50px;">
            @foreach($exams->take(4) as $exam)
            <div class="modern-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="modern-card-header" style="background: linear-gradient(90deg, var(--orange-light), var(--orange));"></div>
                <div class="modern-card-body">
                    <span class="badge" style="background: rgba(241, 90, 36, 0.1); color: var(--orange-dark);">{{ $exam->subject->field->name }}</span>
                    <h3>{{ $exam->subject->name }}</h3>
                    <p style="visibility:hidden; height:0; margin:0;">Spacing</p>

                    <div class="modern-card-footer">
                        <div class="modern-card-meta">
                            <div class="meta-item">
                                <i class="ph ph-calendar-blank"></i>
                                <span>{{ \Carbon\Carbon::parse($exam->exam_date)->format('d M, Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="ph ph-clock"></i>
                                <span dir="ltr">{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->end_time)->format('H:i') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="ph ph-users"></i>
                                <span>{{ $exam->registrations_count }} / {{ $exam->max_students }} {{ $locale === 'ar' ? 'مقعد' : 'seats' }}</span>
                            </div>
                        </div>

                        @if($exam->isFull())
                            <div style="background:#fee2e2;color:#b91c1c;padding:12px;border-radius:50px;text-align:center;font-weight:700;font-size:0.95rem;">
                                {{ $locale === 'ar' ? 'اكتملت الأماكن' : 'Fully Booked' }}
                            </div>
                        @else
                            <button onclick="openExamModal({{ $exam->id }}, '{{ addslashes($exam->subject->name) }}')"
                                class="btn btn-primary" style="width:100%;">
                                <i class="ph ph-pencil-line" style="font-size:1.2rem;"></i>
                                {{ $locale === 'ar' ? 'سجل الآن' : 'Register Now' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($exams->count() > 4)
        <div class="text-center" style="margin-top:50px;" data-aos="fade-up">
            <a href="{{ route('exams.page') }}" class="btn btn-outline" style="color:var(--orange); border-color:var(--orange);">
                {{ $locale === 'ar' ? 'عرض جميع الامتحانات' : 'View All Exams' }}
                <i class="ph ph-arrow-{{ $locale === 'ar' ? 'left' : 'right' }}"></i>
            </a>
        </div>
        @endif
    </div>
</section>
@endif

{{-- Exam Registration Modal --}}
<div class="modal-overlay" id="examModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;align-items:center;justify-content:center;">
    <div class="modal-card">
        <h3 style="color:var(--purple-dark);margin-bottom:6px;font-size:1.2rem;" id="examModalTitle"></h3>
        <p style="color:var(--text-gray);margin-bottom:20px;font-size:.9rem;">{{ $locale === 'ar' ? 'أدخل بياناتك للتسجيل في هذا الامتحان' : 'Enter your details to register' }}</p>
        <form action="{{ route('exam.register') }}" method="POST">
            @csrf
            <input type="hidden" name="exam_id" id="examId">
            <div style="margin-bottom:14px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'الاسم الكامل *' : 'Full Name *' }}</label><input type="text" name="student_name" class="form-control" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" required></div>
            <div style="margin-bottom:14px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'الدولة *' : 'Country *' }}</label><input type="text" name="country" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" required></div>
            <div style="margin-bottom:14px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'البريد الإلكتروني *' : 'Email *' }}</label><input type="email" name="email" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" dir="ltr" required></div>
            <div style="margin-bottom:20px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'رقم الهاتف (واتساب) *' : 'WhatsApp Number *' }}</label><input type="text" name="phone" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" dir="ltr" required></div>
            <div class="modal-actions">
                <button type="button" onclick="closeExamModal()" style="flex:1;padding:11px;border:1.5px solid #e5e7eb;border-radius:8px;background:transparent;cursor:pointer;font-family:inherit;font-size:.9rem;">{{ $locale === 'ar' ? 'إلغاء' : 'Cancel' }}</button>
                <button type="submit" class="btn btn-primary" style="flex:2;justify-content:center;">{{ $locale === 'ar' ? 'تأكيد التسجيل' : 'Confirm Registration' }}</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== TEACHER APPLICATION ===== -->
<section class="section-pad" id="join" style="background:linear-gradient(135deg, var(--purple-dark) 0%, var(--purple) 100%);">
    <div class="container">
        <div class="text-center" style="margin-bottom:50px;">
            <span class="section-label" style="background:rgba(255,255,255,.15);color:#fff;">{{ $locale === 'ar' ? 'انضم لفريقنا' : 'Join Our Team' }}</span>
            <h2 class="section-title" style="color:#fff;">{{ $locale === 'ar' ? 'التقديم كأستاذ أو خبير' : 'Apply as Instructor / Expert' }}</h2>
            <p style="color:rgba(255,255,255,.75);max-width:500px;margin:0 auto;font-size:.95rem;">{{ $locale === 'ar' ? 'هل لديك خبرة في مجالك؟ انضم إلى فريق مصادر التنمية وساهم في تطوير الكفاءات' : 'Share your expertise and join our growing team of professionals.' }}</p>
        </div>

        @if(session('teacher_success'))
            <div style="background:rgba(255,255,255,.15);color:#fff;padding:14px 20px;border-radius:10px;margin-bottom:20px;font-weight:600;text-align:center;">
                <i class="ph ph-check-circle"></i> {{ session('teacher_success') }}
            </div>
        @endif

        <div class="expert-form-card">
            <form action="{{ route('teacher.apply') }}" method="POST">
                @csrf
                <div class="expert-form-grid">
                    <div>
                        <label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;color:#fff;">{{ $locale === 'ar' ? 'الاسم الكامل *' : 'Full Name *' }}</label>
                        <input type="text" name="name" style="width:100%;padding:10px 14px;border:1.5px solid rgba(255,255,255,.2);border-radius:8px;font-family:inherit;font-size:.92rem;background:rgba(255,255,255,.1);color:#fff;" required>
                    </div>
                    <div>
                        <label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;color:#fff;">{{ $locale === 'ar' ? 'المجال *' : 'Field *' }}</label>
                        <select name="field_id" style="width:100%;padding:10px 14px;border:1.5px solid rgba(255,255,255,.2);border-radius:8px;font-family:inherit;font-size:.92rem;background:rgba(255,255,255,.1);color:#fff;" required>
                            <option value="">{{ $locale === 'ar' ? 'اختر مجالاً' : 'Select Field' }}</option>
                            @foreach($fields as $f)<option value="{{ $f->id }}" style="color:#000;">{{ $f->name }}</option>@endforeach
                        </select>
                    </div>
                </div>
                <div class="expert-form-grid">
                    <div>
                        <label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;color:#fff;">{{ $locale === 'ar' ? 'رقم الهاتف *' : 'Phone *' }}</label>
                        <input type="text" name="phone" style="width:100%;padding:10px 14px;border:1.5px solid rgba(255,255,255,.2);border-radius:8px;font-family:inherit;font-size:.92rem;background:rgba(255,255,255,.1);color:#fff;" dir="ltr" required>
                    </div>
                    <div>
                        <label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;color:#fff;">{{ $locale === 'ar' ? 'البريد الإلكتروني *' : 'Email *' }}</label>
                        <input type="email" name="email" style="width:100%;padding:10px 14px;border:1.5px solid rgba(255,255,255,.2);border-radius:8px;font-family:inherit;font-size:.92rem;background:rgba(255,255,255,.1);color:#fff;" dir="ltr" required>
                    </div>
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;color:#fff;">{{ $locale === 'ar' ? 'ملخص عن خبرتك *' : 'Brief about yourself *' }}</label>
                    <textarea name="bio" rows="4" style="width:100%;padding:10px 14px;border:1.5px solid rgba(255,255,255,.2);border-radius:8px;font-family:inherit;font-size:.92rem;background:rgba(255,255,255,.1);color:#fff;resize:vertical;" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;background:var(--orange);padding:14px;">
                    <i class="ph ph-paper-plane-tilt"></i>
                    {{ $locale === 'ar' ? 'إرسال الطلب' : 'Submit Application' }}
                </button>
            </form>
        </div>
    </div>
</section>

<!-- ===== CONTACT ===== -->
<section class="contact section-pad" id="contact">
    <div class="container">
        <div class="text-center" style="margin-bottom:60px;">
            <span class="section-label">{{ __('nav.contact') }}</span>
            <h2 class="section-title">{{ __('contact.title') }}</h2>
        </div>

        <div class="contact-grid">
            <!-- Contact Info -->
            <div data-aos="fade-{{ $locale === 'ar' ? 'left' : 'right' }}">
                <div class="contact-card">
                    <div class="contact-item">
                        <div class="contact-item-icon"><i class="ph ph-map-pin" style="font-size:1.5rem;color:var(--orange);"></i></div>
                        <div class="contact-item-text">
                            <strong>{{ __('contact.address_label') }}</strong>
                            <span>{{ __('contact.address') }}</span>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-item-icon"><i class="ph ph-phone" style="font-size:1.5rem;color:var(--orange);"></i></div>
                        <div class="contact-item-text">
                            <strong>{{ __('contact.phone_label') }}</strong>
                            <a href="https://wa.me/218944912629" target="_blank" style="display: inline-flex; align-items: center; gap: 6px;"><i class="ph ph-whatsapp-logo" style="color:#25D366;"></i> 094-4912629</a>
                            <a href="https://wa.me/218915072629" target="_blank" style="display: inline-flex; align-items: center; gap: 6px;"><i class="ph ph-whatsapp-logo" style="color:#25D366;"></i> 0915072629</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-item-icon"><i class="ph ph-buildings" style="font-size:1.5rem;color:var(--orange);"></i></div>
                        <div class="contact-item-text">
                            <strong>{{ $locale === 'ar' ? 'الشركة' : 'Company' }}</strong>
                            <span>{{ $locale === 'ar' ? 'مصادر التنمية' : 'Resources of Development' }}</span>
                            <span style="font-size:0.85rem; margin-top:4px;">Resources of Development</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div data-aos="fade-{{ $locale === 'ar' ? 'right' : 'left' }}" data-aos-delay="150">
                <div class="contact-map-wrap">
                    <div class="map-label">
                        <div class="map-label-icon"><i class="ph ph-map-pin"></i></div>
                        {{ __('contact.map_label') }}
                    </div>
                    <iframe
                        src="https://maps.google.com/maps?q={{ urlencode('مدارس إدراك الدولية, Benghazi') }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="{{ __('contact.map_label') }}">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand -->
            <div class="footer-brand" data-aos="fade-up">
                <img src="{{ asset('assets/logo.png') }}" alt="{{ __('hero.title') }}">
                <p>{{ __('about.desc') }}</p>
            </div>

            <!-- Quick Links -->
            <div data-aos="fade-up" data-aos-delay="100">
                <h4 class="footer-title">{{ __('footer.quick') }}</h4>
                <ul class="footer-links">
                    <li><a href="#home">{{ __('nav.home') }}</a></li>
                    <li><a href="#about">{{ __('nav.about') }}</a></li>
                    <li><a href="#courses">{{ $locale === 'ar' ? 'الدورات' : 'Courses' }}</a></li>
                    <li><a href="#exams">{{ $locale === 'ar' ? 'الامتحانات' : 'Exams' }}</a></li>
                    <li><a href="#contact">{{ __('nav.contact') }}</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div data-aos="fade-up" data-aos-delay="200">
                <h4 class="footer-title">{{ __('footer.contact') }}</h4>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon"><i class="ph ph-map-pin"></i></div>
                    <span>{{ __('contact.address') }}</span>
                </div>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon"><i class="ph ph-phone"></i></div>
                    <div>
                        <a href="https://wa.me/218944912629" target="_blank">094-4912629</a><br>
                        <a href="https://wa.me/218915072629" target="_blank">0915072629</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <span class="footer-bottom-text">
                &copy; {{ date('Y') }} {{ __('hero.title') }}. {{ __('footer.rights') }}.
            </span>
            <div class="dev-credit">
                <span>{{ __('footer.dev_by') }}</span>
                <img src="{{ asset('assets/code.jpg') }}" alt="Code">
                <span style="color:rgba(255,255,255,0.75); font-weight:600;">Code</span>
            </div>
        </div>
    </div>
</footer>

@endsection

@push('scripts')
<script>
function openExamModal(id, name) {
    document.getElementById('examId').value = id;
    document.getElementById('examModalTitle').textContent = name;
    const m = document.getElementById('examModal');
    m.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeExamModal() {
    document.getElementById('examModal').style.display = 'none';
    document.body.style.overflow = '';
}
function openCourseModal(id, name) {
    document.getElementById('courseId').value = id;
    document.getElementById('courseModalTitle').textContent = name;
    const m = document.getElementById('courseModal');
    m.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeCourseModal() {
    document.getElementById('courseModal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('examModal')?.addEventListener('click', function(e) { if(e.target === this) closeExamModal(); });
document.getElementById('courseModal')?.addEventListener('click', function(e) { if(e.target === this) closeCourseModal(); });
</script>
@endpush
