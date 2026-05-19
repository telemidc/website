<!DOCTYPE html>
<html lang="{{ $locale ?? 'ar' }}" dir="{{ ($locale ?? 'ar') === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('hero.subtitle') }} - {{ __('contact.address') }}">
    <title>{{ __('hero.title') }} | {{ __('nav.home') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- AOS Animations -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />

    <!-- Icons (Phosphor Icons) -->
    <script src="https://unpkg.com/@phosphor-icons/web@2.0.3/src/index.js" defer></script>
</head>
<body lang="{{ $locale ?? 'ar' }}">

@php
    $isHomePage = request()->routeIs('home');
    $navHome = $isHomePage ? '#home' : route('home') . '#home';
    $navAbout = $isHomePage ? '#about' : route('home') . '#about';
    $navCourses = $isHomePage ? '#courses' : route('home') . '#courses';
    $navExams = $isHomePage ? '#exams' : route('home') . '#exams';
    $navJoin = $isHomePage ? '#join' : route('home') . '#join';
    $navContact = $isHomePage ? '#contact' : route('home') . '#contact';
@endphp

<!-- ===== NAVBAR ===== -->
<nav class="navbar" id="navbar">
    <div class="container">
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="nav-logo">
                <img src="{{ asset('assets/logo.png') }}" alt="{{ __('hero.title') }} Logo">
            </a>

            <ul class="nav-menu">
                <li><a href="{{ $navHome }}" class="nav-link">{{ __('nav.home') }}</a></li>
                <li><a href="{{ $navAbout }}" class="nav-link">{{ __('nav.about') }}</a></li>
                <li><a href="{{ $navCourses }}" class="nav-link">{{ ($locale ?? 'ar') === 'ar' ? 'الدورات' : 'Courses' }}</a></li>
                <li><a href="{{ $navExams }}" class="nav-link">{{ ($locale ?? 'ar') === 'ar' ? 'الامتحانات' : 'Exams' }}</a></li>
                <li><a href="{{ $navJoin }}" class="nav-link">{{ ($locale ?? 'ar') === 'ar' ? 'التقديم كخبير' : 'Apply as Expert' }}</a></li>
                <li><a href="{{ $navContact }}" class="nav-link">{{ __('nav.contact') }}</a></li>
                <li>
                    <a href="{{ route('lang.switch', __('lang.code')) }}" class="lang-btn">
                        <i class="ph ph-translate-tts"></i>
                        {{ __('lang.switch') }}
                    </a>
                </li>
            </ul>

            <button class="nav-hamburger" id="hamburgerBtn" aria-label="Menu">
                <i class="ph ph-list"></i>
            </button>
        </div>
    </div>
</nav>

<!-- ===== MOBILE MENU ===== -->
<div class="mobile-menu" id="mobileMenu">
    <button class="mobile-menu-close" id="mobileClose" aria-label="Close">
        <i class="ph ph-x"></i>
    </button>
    <a href="{{ $navHome }}" class="mobile-nav-link" onclick="closeMobileMenu()">{{ __('nav.home') }}</a>
    <a href="{{ $navAbout }}" class="mobile-nav-link" onclick="closeMobileMenu()">{{ __('nav.about') }}</a>
    <a href="{{ $navCourses }}" class="mobile-nav-link" onclick="closeMobileMenu()">{{ ($locale ?? 'ar') === 'ar' ? 'الدورات' : 'Courses' }}</a>
    <a href="{{ $navExams }}" class="mobile-nav-link" onclick="closeMobileMenu()">{{ ($locale ?? 'ar') === 'ar' ? 'الامتحانات' : 'Exams' }}</a>
    <a href="{{ $navJoin }}" class="mobile-nav-link" onclick="closeMobileMenu()">{{ ($locale ?? 'ar') === 'ar' ? 'التقديم كخبير' : 'Apply as Expert' }}</a>
    <a href="{{ $navContact }}" class="mobile-nav-link" onclick="closeMobileMenu()">{{ __('nav.contact') }}</a>
    <a href="{{ route('lang.switch', __('lang.code')) }}" class="lang-btn" style="margin-top:16px">
        <i class="ph ph-translate-tts"></i>
        {{ __('lang.switch') }}
    </a>
</div>

<!-- MAIN CONTENT -->
@yield('content')

<!-- ===== BACK TO TOP ===== -->
<a href="#home" class="back-to-top" id="backToTop" aria-label="Back to top">
    <i class="ph ph-arrow-up"></i>
</a>

<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 60
    });

    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Back to top
    const backToTop = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    });

    // Mobile menu
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileClose = document.getElementById('mobileClose');

    hamburgerBtn.addEventListener('click', () => {
        mobileMenu.classList.add('open');
        document.body.style.overflow = 'hidden';
    });

    mobileClose.addEventListener('click', closeMobileMenu);
    mobileMenu.addEventListener('click', (e) => {
        if(e.target === mobileMenu) closeMobileMenu();
    });

    function closeMobileMenu() {
        mobileMenu.classList.remove('open');
        document.body.style.overflow = '';
    }

    // Smooth anchor scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Stats counter animation
    function animateCounter(el) {
        const target = parseInt(el.getAttribute('data-target'));
        const duration = 2000;
        const start = performance.now();
        const update = (time) => {
            const elapsed = time - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(eased * target).toLocaleString();
            if (progress < 1) requestAnimationFrame(update);
        };
        requestAnimationFrame(update);
    }

    // Trigger counters when stats section visible
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                document.querySelectorAll('.stat-number').forEach(animateCounter);
                statsObserver.disconnect();
            }
        });
    }, { threshold: 0.3 });

    const statsSection = document.querySelector('.stats');
    if (statsSection) statsObserver.observe(statsSection);
</script>

@stack('scripts')
</body>
</html>
