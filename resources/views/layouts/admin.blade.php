<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - مصادر التنمية</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --orange:#F15A24;--purple:#4B2991;--purple-dark:#361d6e;--purple-light:#6b3ec0;
            --sidebar-w:260px;
            --white:#fff;
            --off-white:#f4f6fb;
            --border:#e5e7eb;
            --text-dark:#1a1a2e;
            --text-gray:#6b7280;
            --radius:16px;--radius-sm:10px;
            --shadow:0 8px 30px rgba(75,41,145,0.06);
            --shadow-hover:0 12px 40px rgba(75,41,145,0.12);
            --topbar-bg:rgba(255,255,255,0.8);
            --table-hover:rgba(75,41,145,.03);
            --card-header-bg:rgba(255,255,255,0.5);
            --sidebar-bg:linear-gradient(180deg, var(--purple-dark) 0%, var(--purple) 100%);
        }
        [data-theme="dark"] {
            --white:#1e1e2d;
            --off-white:#151521;
            --border:#2b2b40;
            --text-dark:#ffffff;
            --text-gray:#92929f;
            --shadow:0 8px 30px rgba(0,0,0,0.3);
            --shadow-hover:0 12px 40px rgba(0,0,0,0.5);
            --topbar-bg:rgba(30,30,45,0.8);
            --table-hover:rgba(255,255,255,.03);
            --card-header-bg:rgba(30,30,45,0.5);
            --sidebar-bg:linear-gradient(180deg, #1a1a27 0%, #11111a 100%);
        }
        body{font-family:'Cairo',sans-serif;background:var(--off-white);color:var(--text-dark);display:flex;min-height:100vh;overflow-x:hidden;transition:background 0.3s, color 0.3s;}
        
        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        /* Sidebar */
        .sidebar{width:var(--sidebar-w);background:var(--sidebar-bg);height:100vh;position:fixed;top:0;right:0;z-index:100;display:flex;flex-direction:column;transition:transform .4s cubic-bezier(0.4, 0, 0.2, 1), background 0.3s;box-shadow:-4px 0 20px rgba(0,0,0,0.1);}
        .sidebar-logo{padding:28px 20px;border-bottom:1px solid rgba(255,255,255,.08);display:flex;align-items:center;gap:12px;}
        .sidebar-logo img{height:44px;object-fit:contain;filter:brightness(0) invert(1);}
        .sidebar-logo span{color:#fff;font-weight:700;font-size:1.1rem;line-height:1.3;}
        .sidebar-nav{flex:1;padding:24px 0;overflow-y:auto;}
        .nav-section{padding:12px 24px 8px;color:rgba(255,255,255,.5);font-size:.75rem;font-weight:700;letter-spacing:.05em;}
        .nav-item{display:flex;align-items:center;gap:12px;padding:12px 24px;color:rgba(255,255,255,.8);text-decoration:none;font-size:.95rem;font-weight:600;transition:all .3s ease;border-right:4px solid transparent;position:relative;overflow:hidden;}
        .nav-item::before{content:'';position:absolute;left:0;top:0;bottom:0;width:0;background:rgba(255,255,255,.08);transition:width .3s ease;z-index:-1;}
        .nav-item:hover::before, .nav-item.active::before{width:100%;}
        .nav-item:hover,.nav-item.active{color:#fff;border-right-color:var(--orange);}
        .nav-item.active{background:rgba(255,255,255,.1);}
        .nav-item i{font-size:1.3rem;width:24px;}
        
        .sidebar-footer{padding:20px 24px;border-top:1px solid rgba(255,255,255,.08);background:rgba(0,0,0,.15);display:flex;flex-direction:column;gap:16px;}
        .sidebar-footer form button{display:flex;align-items:center;gap:10px;color:rgba(255,255,255,.8);background:none;border:none;cursor:pointer;font-family:inherit;font-size:.95rem;font-weight:600;width:100%;transition:color .2s;}
        .sidebar-footer form button:hover{color:var(--orange);}
        .dev-credit {display:flex;align-items:center;gap:8px;font-size:0.75rem;color:rgba(255,255,255,0.6);border-top:1px solid rgba(255,255,255,0.05);padding-top:16px;}
        .dev-credit img {height:20px;border-radius:4px;}

        /* Main */
        .main-wrap{margin-right:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh;}
        .topbar{background:var(--topbar-bg);backdrop-filter:blur(10px);padding:18px 36px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 2px 10px rgba(0,0,0,.03);position:sticky;top:0;z-index:50;transition:background 0.3s;}
        .topbar-title{font-size:1.3rem;font-weight:800;color:var(--purple);animation:slideInRight 0.5s ease;}
        .topbar-right{display:flex;align-items:center;gap:20px;}
        .theme-toggle{background:none;border:none;color:var(--text-gray);font-size:1.4rem;cursor:pointer;transition:color 0.3s;}
        .theme-toggle:hover{color:var(--orange);}
        .topbar-user{display:flex;align-items:center;gap:12px;color:var(--text-gray);font-weight:600;}
        .topbar-user .avatar{width:40px;height:40px;border-radius:12px;background:var(--orange);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1rem;box-shadow:0 4px 10px rgba(241,90,36,0.3);}
        
        .main-content{padding:36px;flex:1;animation:fadeInUp 0.6s ease-out;}

        /* Cards & Tables */
        .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:24px;margin-bottom:36px;}
        .stat-card{background:var(--white);border-radius:var(--radius);padding:24px;box-shadow:var(--shadow);display:flex;align-items:center;gap:18px;transition:transform .3s ease, box-shadow .3s ease, background 0.3s;}
        .stat-card:hover{transform:translateY(-5px);box-shadow:var(--shadow-hover);}
        .stat-card:nth-child(1){animation-delay:0.1s;} .stat-card:nth-child(2){animation-delay:0.2s;} .stat-card:nth-child(3){animation-delay:0.3s;}
        .stat-card:nth-child(4){animation-delay:0.4s;} .stat-card:nth-child(5){animation-delay:0.5s;} .stat-card:nth-child(6){animation-delay:0.6s;}
        
        .stat-card .icon{width:56px;height:56px;border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;font-size:1.6rem;transition:transform .3s;}
        .stat-card:hover .icon{transform:scale(1.1);}
        .stat-card .info h3{font-size:1.9rem;font-weight:800;color:var(--text-dark);line-height:1.2;}
        .stat-card .info p{font-size:.85rem;color:var(--text-gray);font-weight:600;margin-top:4px;}
        
        .card{background:var(--white);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;margin-bottom:32px;transition:box-shadow .3s, background 0.3s;animation:fadeInUp 0.5s ease-out;}
        .card:hover{box-shadow:var(--shadow-hover);}
        .card-header{padding:20px 28px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;background:var(--card-header-bg);transition:background 0.3s;}
        .card-header h3{font-size:1.1rem;font-weight:800;color:var(--purple);display:flex;align-items:center;gap:8px;}
        .card-body{padding:28px;}
        
        table{width:100%;border-collapse:separate;border-spacing:0;}
        th{background:var(--off-white);padding:14px 20px;text-align:right;font-size:.85rem;font-weight:700;color:var(--text-gray);text-transform:uppercase;letter-spacing:.05em;transition:background 0.3s;}
        th:first-child{border-top-right-radius:8px;border-bottom-right-radius:8px;} th:last-child{border-top-left-radius:8px;border-bottom-left-radius:8px;}
        td{padding:16px 20px;border-bottom:1px solid var(--border);font-size:.92rem;vertical-align:middle;transition:background .2s;}
        tr{transition:transform .2s, box-shadow .2s;}
        tr:hover td{background:var(--table-hover);}
        
        /* Buttons */
        .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:var(--radius-sm);font-family:inherit;font-size:.9rem;font-weight:700;cursor:pointer;text-decoration:none;border:none;transition:all .3s ease;}
        .btn-primary{background:var(--orange);color:#fff;box-shadow:0 4px 12px rgba(241,90,36,0.2);} .btn-primary:hover{background:#d44e1e;transform:translateY(-2px);box-shadow:0 6px 16px rgba(241,90,36,0.3);}
        .btn-purple{background:var(--purple);color:#fff;box-shadow:0 4px 12px rgba(75,41,145,0.2);} .btn-purple:hover{background:var(--purple-dark);transform:translateY(-2px);box-shadow:0 6px 16px rgba(75,41,145,0.3);}
        .btn-outline{background:transparent;border:2px solid var(--border);color:var(--text-gray);} .btn-outline:hover{border-color:var(--purple);color:var(--purple);background:rgba(75,41,145,.05);}
        .btn-danger{background:#fee2e2;color:#b91c1c;} .btn-danger:hover{background:#fecaca;}
        .btn-success{background:#dcfce7;color:#15803d;} .btn-success:hover{background:#bbf7d0;}
        .btn-warning{background:#fef9c3;color:#854d0e;} .btn-warning:hover{background:#fef08a;}
        .btn-sm{padding:6px 14px;font-size:.82rem;}

        /* Forms */
        .form-group{margin-bottom:20px;}
        .form-label{display:block;font-weight:700;font-size:.9rem;margin-bottom:8px;color:var(--text-dark);}
        .form-control{width:100%;padding:12px 16px;border:2px solid var(--border);border-radius:var(--radius-sm);font-family:inherit;font-size:.95rem;transition:all .3s;background:var(--white);color:var(--text-dark);}
        .form-control:focus{outline:none;border-color:var(--purple);box-shadow:0 0 0 4px rgba(75,41,145,0.1);}
        select.form-control{cursor:pointer;}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;}

        /* Search Box */
        .search-box {display:flex;align-items:center;background:var(--off-white);border:1px solid var(--border);border-radius:30px;padding:4px 16px;transition:all .3s;}
        .search-box:focus-within {border-color:var(--purple);background:var(--white);box-shadow:0 0 0 3px rgba(75,41,145,0.1);}
        .search-box input {border:none;background:transparent;padding:8px;outline:none;font-family:inherit;font-size:.9rem;width:200px;color:var(--text-dark);}
        .search-box button {background:none;border:none;color:var(--purple);cursor:pointer;font-size:1.1rem;}

        /* Alerts */
        .alert{padding:14px 20px;border-radius:var(--radius-sm);margin-bottom:24px;font-size:.95rem;font-weight:700;display:flex;align-items:center;gap:12px;animation:slideInRight 0.4s ease;}
        .alert-success{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;}
        .alert-error{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;}

        /* Badge */
        .badge{display:inline-flex;align-items:center;padding:4px 12px;border-radius:30px;font-size:.78rem;font-weight:700;letter-spacing:.02em;}
        .badge-pending{background:#fef9c3;color:#854d0e;}
        .badge-hired{background:#dcfce7;color:#15803d;}
        .badge-rejected{background:#fee2e2;color:#b91c1c;}
        .badge-visible{background:#dbeafe;color:#1e40af;}
        .badge-hidden{background:#374151;color:#f3f4f6;} /* updated for better dark mode visibility */

        /* Modal */
        .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:1000;align-items:center;justify-content:center;opacity:0;transition:opacity .3s;}
        .modal-overlay.open{display:flex;opacity:1;}
        .modal{background:var(--white);border-radius:var(--radius);padding:36px;max-width:540px;width:92%;max-height:90vh;overflow-y:auto;transform:scale(0.95);transition:transform .3s cubic-bezier(0.4, 0, 0.2, 1);box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);}
        .modal-overlay.open .modal{transform:scale(1);}
        .modal-title{font-size:1.2rem;font-weight:800;color:var(--purple);margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid var(--border);}
        
        @media(max-width:900px){
            .sidebar{transform:translateX(100%);} .main-wrap{margin-right:0;}
            .form-grid{grid-template-columns:1fr;}
        }
    </style>
    <script>
        // Init theme
        const savedTheme = localStorage.getItem('adminTheme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo">
        <span>مصادر التنمية<br><small style="font-weight:400;opacity:.8;font-size:.8rem;">لوحة التحكم</small></span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">الرئيسية</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="ph ph-squares-four"></i> لوحة التحكم
        </a>

        <div class="nav-section">المحتوى التعليمي</div>
        <a href="{{ route('admin.fields.index') }}" class="nav-item {{ request()->routeIs('admin.fields.*') ? 'active' : '' }}">
            <i class="ph ph-folders"></i> المجالات التعليمية
        </a>
        <a href="{{ route('admin.subjects.index') }}" class="nav-item {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
            <i class="ph ph-book-open"></i> المواد الدراسية
        </a>
        <a href="{{ route('admin.exams.index') }}" class="nav-item {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}">
            <i class="ph ph-exam"></i> الامتحانات
        </a>
        <a href="{{ route('admin.courses.index') }}" class="nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
            <i class="ph ph-chalkboard-teacher"></i> الدورات التدريبية
        </a>

        <div class="nav-section">الموارد البشرية</div>
        <a href="{{ route('admin.teachers.index') }}" class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
            <i class="ph ph-users-three"></i> الأساتذة والخبراء
        </a>

        <div class="nav-section">الشهادات والتوثيق</div>
        <a href="{{ route('admin.certificates.index') }}" class="nav-item {{ request()->routeIs('admin.certificates.index') ? 'active' : '' }}">
            <i class="ph ph-certificate"></i> سجل الشهادات
        </a>
        <a href="{{ route('admin.certificates.search') }}" class="nav-item {{ request()->routeIs('admin.certificates.search') ? 'active' : '' }}">
            <i class="ph ph-magnifying-glass"></i> التحقق من شهادة
        </a>

        <div class="nav-section">إدارة النظام</div>
        <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="ph ph-chart-pie-slice"></i> التقارير والإحصائيات
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="ph ph-shield-check"></i> مدراء النظام
        </a>
    </nav>
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"><i class="ph ph-sign-out"></i> تسجيل الخروج</button>
        </form>
        <div class="dev-credit">
            <span>التطوير بواسطة</span>
            <img src="{{ asset('assets/code.jpg') }}" alt="Code;">
            <strong style="color:#fff;">Code;</strong>
        </div>
    </div>
</aside>

<div class="main-wrap">
    <div class="topbar">
        <span class="topbar-title">@yield('title', 'لوحة التحكم')</span>
        <div class="topbar-right">
            <button class="theme-toggle" id="themeToggleBtn" aria-label="تبديل المظهر">
                <i class="ph ph-moon"></i>
            </button>
            <div class="topbar-user">
                <span>{{ auth()->user()->name }}</span>
                <div class="avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</div>
            </div>
        </div>
    </div>
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success"><i class="ph ph-check-circle" style="font-size:1.4rem;"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="ph ph-warning-circle" style="font-size:1.4rem;"></i> {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>

<script>
    const themeBtn = document.getElementById('themeToggleBtn');
    const icon = themeBtn.querySelector('i');
    
    function updateIcon(theme) {
        if(theme === 'dark') {
            icon.classList.remove('ph-moon');
            icon.classList.add('ph-sun');
        } else {
            icon.classList.remove('ph-sun');
            icon.classList.add('ph-moon');
        }
    }
    
    // Initial icon state
    updateIcon(document.documentElement.getAttribute('data-theme'));

    themeBtn.addEventListener('click', () => {
        let currentTheme = document.documentElement.getAttribute('data-theme');
        let newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('adminTheme', newTheme);
        updateIcon(newTheme);
    });
</script>
</body>
</html>
