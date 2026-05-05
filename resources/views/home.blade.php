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
                        <div class="accred-icon">🏆</div>
                        <h4>{{ __('about.accred_title') }}</h4>
                        <p>{{ __('about.accred_desc') }}</p>
                    </div>
                    <div class="accred-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="accred-icon">✅</div>
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

<!-- ===== EXAMS ===== -->
@if(isset($exams) && $exams->count() > 0)
<section class="exams section-pad" id="exams" style="background: var(--off-white);">
    <div class="container">
        <div class="text-center">
            <span class="section-label">{{ $locale === 'ar' ? 'التسجيل مفتوح' : 'Registration Open' }}</span>
            <h2 class="section-title">{{ $locale === 'ar' ? 'مواعيد الامتحانات القادمة' : 'Upcoming Exams' }}</h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-top: 40px;">
            @foreach($exams as $exam)
            <div style="background: var(--white); border-radius: var(--radius); padding: 24px; box-shadow: var(--shadow); position: relative; overflow: hidden; border-top: 4px solid var(--orange);" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <h3 style="color: var(--purple-dark); margin-bottom: 16px; font-size: 1.3rem;">{{ $exam->course_name }}</h3>
                
                <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: var(--text-gray);">
                        <i class="ph ph-calendar-blank" style="color: var(--orange); font-size: 1.2rem;"></i>
                        <span>{{ \Carbon\Carbon::parse($exam->exam_date)->format('Y-m-d') }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; color: var(--text-gray);">
                        <i class="ph ph-clock" style="color: var(--orange); font-size: 1.2rem;"></i>
                        <span dir="ltr">{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->end_time)->format('H:i') }}</span>
                    </div>
                </div>

                @php
                    $waMsg = urlencode(($locale === 'ar' ? 'مرحباً، أرغب بالتسجيل في امتحان دورة: ' : 'Hello, I want to register for the exam: ') . $exam->course_name);
                @endphp
                <a href="https://wa.me/218944912629?text={{ $waMsg }}" target="_blank" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <i class="ph ph-whatsapp-logo"></i>
                    {{ $locale === 'ar' ? 'سجل الآن' : 'Register Now' }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== SERVICES ===== -->
<section class="services section-pad" id="services">
    <div class="container">
        <div class="text-center">
            <span class="section-label">{{ __('services.subtitle') }}</span>
            <h2 class="section-title">{{ __('services.title') }}</h2>
        </div>

        <div class="services-grid">
            <div class="service-card" data-aos="fade-up" data-aos-delay="0">
                <div class="service-icon-wrap">🎯</div>
                <h3>{{ __('services.s1_title') }}</h3>
                <p>{{ __('services.s1_desc') }}</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="80">
                <div class="service-icon-wrap">🏛️</div>
                <h3>{{ __('services.s2_title') }}</h3>
                <p>{{ __('services.s2_desc') }}</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="160">
                <div class="service-icon-wrap">💡</div>
                <h3>{{ __('services.s3_title') }}</h3>
                <p>{{ __('services.s3_desc') }}</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="240">
                <div class="service-icon-wrap">🏅</div>
                <h3>{{ __('services.s4_title') }}</h3>
                <p>{{ __('services.s4_desc') }}</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="320">
                <div class="service-icon-wrap">⚙️</div>
                <h3>{{ __('services.s5_title') }}</h3>
                <p>{{ __('services.s5_desc') }}</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                <div class="service-icon-wrap">🌟</div>
                <h3>{{ __('services.s6_title') }}</h3>
                <p>{{ __('services.s6_desc') }}</p>
            </div>
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
                        <div class="contact-item-icon">📍</div>
                        <div class="contact-item-text">
                            <strong>{{ __('contact.address_label') }}</strong>
                            <span>{{ __('contact.address') }}</span>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-item-icon">📞</div>
                        <div class="contact-item-text">
                            <strong>{{ __('contact.phone_label') }}</strong>
                            <a href="https://wa.me/218944912629" target="_blank" style="display: inline-flex; align-items: center; gap: 6px;"><i class="ph ph-whatsapp-logo" style="color:#25D366;"></i> 094-4912629</a>
                            <a href="https://wa.me/218915072629" target="_blank" style="display: inline-flex; align-items: center; gap: 6px;"><i class="ph ph-whatsapp-logo" style="color:#25D366;"></i> 0915072629</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-item-icon">🏢</div>
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
                        <div class="map-label-icon">📍</div>
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
                    <li><a href="#services">{{ __('nav.services') }}</a></li>
                    <li><a href="#contact">{{ __('nav.contact') }}</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div data-aos="fade-up" data-aos-delay="200">
                <h4 class="footer-title">{{ __('footer.contact') }}</h4>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">📍</div>
                    <span>{{ __('contact.address') }}</span>
                </div>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">📞</div>
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
