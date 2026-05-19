@extends('layouts.app')

@section('content')
<section class="section-pad" style="padding-top:120px;min-height:100vh;background:var(--off-white);">
    <div class="container">
        <div class="public-topbar">
            <div>
                <h1 style="color:var(--purple-dark);font-size:2rem;margin-bottom:6px;">
                    <i class="ph ph-exam" style="color:var(--orange);"></i>
                    {{ $locale === 'ar' ? 'جميع الامتحانات المتاحة' : 'All Available Exams' }}
                </h1>
                <p style="color:var(--text-gray);font-size:.95rem;">
                    {{ $locale === 'ar' ? 'تصفح مواعيد الامتحانات وسجل فيما يناسبك' : 'Browse exam dates and register' }}
                </p>
            </div>
            <a href="{{ route('home') }}#exams" class="btn btn-outline">
                <i class="ph ph-arrow-right"></i>
                {{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}
            </a>
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('exams.page') }}" class="public-search-form">
            <div class="public-search-input-wrap">
                <i class="ph ph-magnifying-glass" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:var(--text-gray);"></i>
                <input type="text" name="q" value="{{ $search }}"
                       placeholder="{{ $locale === 'ar' ? 'بحث بالمادة أو المجال...' : 'Search by subject or field...' }}"
                       style="width:100%;padding:12px 40px 12px 14px;border:1.5px solid #e5e7eb;border-radius:10px;font-family:inherit;font-size:.92rem;direction:rtl;">
            </div>
            <button type="submit" class="btn btn-primary" style="padding:12px 20px;">
                {{ $locale === 'ar' ? 'بحث' : 'Search' }}
            </button>
            @if($search)
            <a href="{{ route('exams.page') }}" class="btn btn-outline" style="padding:12px 16px;">
                <i class="ph ph-x"></i>
            </a>
            @endif
        </form>

        @if($search && $exams->total() > 0)
        <p style="margin-bottom:20px;color:var(--text-gray);font-size:.9rem;">
            {{ $locale === 'ar' ? 'نتائج البحث عن' : 'Results for' }} "<strong>{{ $search }}</strong>" — {{ $exams->total() }} {{ $locale === 'ar' ? 'نتيجة' : 'results' }}
        </p>
        @endif

        @if(session('success'))
            <div style="background:#dcfce7;color:#15803d;padding:14px 20px;border-radius:10px;margin:0 0 20px;font-weight:600;text-align:center;">
                <i class="ph ph-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#fee2e2;color:#b91c1c;padding:14px 20px;border-radius:10px;margin:0 0 20px;font-weight:600;text-align:center;">
                <i class="ph ph-warning-circle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Exams Grid -->
        <div class="listing-grid">
            @forelse($exams as $exam)
            <div class="modern-card" data-aos="fade-up">
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
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--text-gray);">
                <i class="ph ph-exam" style="font-size:3rem;display:block;margin-bottom:12px;color:#ddd;"></i>
                @if($search)
                    {{ $locale === 'ar' ? 'لا توجد نتائج للبحث' : 'No results found' }}
                @else
                    {{ $locale === 'ar' ? 'لا توجد امتحانات متاحة حالياً' : 'No exams available' }}
                @endif
            </div>
            @endforelse
        </div>

        @if($exams->hasPages())
        <div style="margin-top:36px;display:flex;justify-content:center;">
            {{ $exams->links() }}
        </div>
        @endif
    </div>
</section>

{{-- Exam Registration Modal --}}
<div id="examModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;align-items:center;justify-content:center;">
    <div class="modal-card">
        <h3 style="color:var(--purple-dark);margin-bottom:6px;font-size:1.2rem;" id="examModalTitle"></h3>
        <p style="color:var(--text-gray);margin-bottom:20px;font-size:.9rem;">{{ $locale === 'ar' ? 'أدخل بياناتك للتسجيل في هذا الامتحان' : 'Enter your details to register' }}</p>
        <form action="{{ route('exam.register') }}" method="POST">
            @csrf
            <input type="hidden" name="exam_id" id="examId">
            <div style="margin-bottom:14px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'الاسم الكامل *' : 'Full Name *' }}</label><input type="text" name="student_name" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" required></div>
            <div style="margin-bottom:14px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'الدولة *' : 'Country *' }}</label><input type="text" name="country" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" required></div>
            <div style="margin-bottom:14px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'البريد الإلكتروني *' : 'Email *' }}</label><input type="email" name="email" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" dir="ltr" required></div>
            <div style="margin-bottom:20px;"><label style="display:block;font-weight:600;margin-bottom:6px;font-size:.88rem;">{{ $locale === 'ar' ? 'رقم الهاتف (واتساب) *' : 'WhatsApp *' }}</label><input type="text" name="phone" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:.92rem;" dir="ltr" required></div>
            <div class="modal-actions">
                <button type="button" onclick="closeExamModal()" style="flex:1;padding:11px;border:1.5px solid #e5e7eb;border-radius:8px;background:transparent;cursor:pointer;font-family:inherit;font-size:.9rem;">{{ $locale === 'ar' ? 'إلغاء' : 'Cancel' }}</button>
                <button type="submit" class="btn btn-primary" style="flex:2;justify-content:center;">{{ $locale === 'ar' ? 'تأكيد التسجيل' : 'Confirm' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openExamModal(id, name) {
    document.getElementById('examId').value = id;
    document.getElementById('examModalTitle').textContent = name;
    document.getElementById('examModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeExamModal() {
    document.getElementById('examModal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('examModal')?.addEventListener('click', function(e) { if(e.target === this) closeExamModal(); });
</script>
@endpush
