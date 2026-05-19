<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamRegistrationController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\TeacherApplicationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ExamController as AdminExamController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\TeacherApplicationController as AdminTeacherController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Pages
Route::get('/courses', [HomeController::class, 'courses'])->name('courses.page');
Route::get('/exams', [HomeController::class, 'exams'])->name('exams.page');

// Public Forms
Route::post('/register-exam', [ExamRegistrationController::class, 'store'])->name('exam.register');
Route::post('/register-course', [CourseRegistrationController::class, 'store'])->name('course.register');
Route::post('/apply-teacher', [TeacherApplicationController::class, 'store'])->name('teacher.apply');

// Admin Panel
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Fields
    Route::get('fields', [FieldController::class, 'index'])->name('fields.index');
    Route::post('fields', [FieldController::class, 'store'])->name('fields.store');
    Route::put('fields/{field}', [FieldController::class, 'update'])->name('fields.update');
    Route::delete('fields/{field}', [FieldController::class, 'destroy'])->name('fields.destroy');

    // Subjects
    Route::get('subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::post('subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::put('subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');

    // Exams
    Route::get('exams', [AdminExamController::class, 'index'])->name('exams.index');
    Route::post('exams', [AdminExamController::class, 'store'])->name('exams.store');
    Route::put('exams/{exam}', [AdminExamController::class, 'update'])->name('exams.update');
    Route::delete('exams/{exam}', [AdminExamController::class, 'destroy'])->name('exams.destroy');
    Route::get('exams/{exam}/registrations', [AdminExamController::class, 'registrations'])->name('exams.registrations');
    Route::patch('exams/{exam}/toggle-status', [AdminExamController::class, 'toggleStatus'])->name('exams.toggleStatus');
    Route::get('exams/results', [AdminExamController::class, 'results'])->name('exams.results');
    Route::post('exam-registrations/{registration}/grade', [AdminExamController::class, 'saveGrade'])->name('exams.saveGrade');
    Route::post('exam-registrations/{registration}/certificate', [AdminExamController::class, 'issueCertificate'])->name('exams.issueCertificate');

    // Courses
    Route::get('courses', [AdminCourseController::class, 'index'])->name('courses.index');
    Route::post('courses', [AdminCourseController::class, 'store'])->name('courses.store');
    Route::put('courses/{course}', [AdminCourseController::class, 'update'])->name('courses.update');
    Route::delete('courses/{course}', [AdminCourseController::class, 'destroy'])->name('courses.destroy');
    Route::post('courses/{course}/toggle', [AdminCourseController::class, 'toggleVisibility'])->name('courses.toggle');
    Route::get('courses/{course}/registrations', [AdminCourseController::class, 'registrations'])->name('courses.registrations');

    // Teachers
    Route::get('teachers', [AdminTeacherController::class, 'index'])->name('teachers.index');
    Route::put('teachers/{teacher}/status', [AdminTeacherController::class, 'updateStatus'])->name('teachers.status');
    Route::post('teachers/{teacher}/hire', [AdminTeacherController::class, 'hire'])->name('teachers.hire');
    Route::post('teachers/direct', [AdminTeacherController::class, 'storeDirect'])->name('teachers.storeDirect');

    // Certificates
    Route::get('certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('certificates/search', [CertificateController::class, 'search'])->name('certificates.search');
    Route::get('certificates/create', [CertificateController::class, 'create'])->name('certificates.create');
    Route::post('certificates', [CertificateController::class, 'store'])->name('certificates.store');
    Route::get('certificates/{certificate}/pdf', [CertificateController::class, 'downloadPdf'])->name('certificates.pdf');

    // System Admins
    Route::resource('users', UserController::class)->except(['show']);

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/pdf', [ReportController::class, 'downloadPdf'])->name('reports.pdf');
});
