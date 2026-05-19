<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{ExamRegistration, CourseRegistration, TeacherApplication, Certificate, Course, Exam};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'exam_registrations'   => ExamRegistration::count(),
            'course_registrations' => CourseRegistration::count(),
            'teacher_applications' => TeacherApplication::where('status', 'pending')->count(),
            'certificates'         => Certificate::count(),
            'courses'              => Course::count(),
            'upcoming_exams'       => Exam::where('exam_date', '>=', today())->count(),
        ];
        $latest_exam_regs   = ExamRegistration::with('exam.subject')->latest()->take(5)->get();
        $latest_course_regs = CourseRegistration::with('course')->latest()->take(5)->get();
        $latest_teachers    = TeacherApplication::with('field')->latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'latest_exam_regs', 'latest_course_regs', 'latest_teachers'));
    }
}
