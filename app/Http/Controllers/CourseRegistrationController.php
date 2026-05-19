<?php
namespace App\Http\Controllers;
use App\Models\{Course, CourseRegistration};
use Illuminate\Http\Request;

class CourseRegistrationController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'student_name' => 'required|string|max:255',
            'country'      => 'required|string|max:100',
            'email'        => 'required|email',
            'phone'        => 'required|string|max:20',
        ]);

        $course = Course::findOrFail($request->course_id);

        if ($course->isFull()) {
            return back()->with('course_error', 'عذراً، امتلأت أماكن هذه الدورة.');
        }

        CourseRegistration::create($request->only('course_id', 'student_name', 'country', 'email', 'phone'));
        return back()->with('course_success', 'تم تسجيلك في الدورة بنجاح! سيتم التواصل معك قريباً.');
    }
}
