@extends('layouts.app')

@section('content')
<section class="section-pad" style="margin-top: 100px; min-height: 70vh; display: flex; align-items: center; justify-content: center; background: var(--off-white);">
    <div class="container" style="max-width: 450px;">
        <div style="background: var(--white); padding: 40px; border-radius: var(--radius); box-shadow: var(--shadow); text-align: center;">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" style="height: 60px; margin-bottom: 20px;">
            <h2 style="color: var(--text-dark); margin-bottom: 30px; font-size: 1.5rem;">تسجيل الدخول للإدارة</h2>
            
            @if ($errors->any())
                <div style="background: #fee2e2; color: #b91c1c; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 0.9rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px; text-align: right;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 1rem;" placeholder="مثال: 0914698191" dir="ltr">
                </div>

                <div style="margin-bottom: 30px; text-align: right;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">كلمة المرور</label>
                    <input type="password" name="password" required style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 1rem;" dir="ltr">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
                    دخول
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
