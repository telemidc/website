<?php
namespace App\Http\Controllers;
use App\Models\{Exam, ExamRegistration};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ExamRegistrationController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'exam_id'      => 'required|exists:exams,id',
            'student_name' => 'required|string|max:255',
            'country'      => 'required|string|max:100',
            'email'        => 'required|email',
            'phone'        => 'required|string|max:20',
        ]);

        $exam = Exam::findOrFail($request->exam_id);

        if ($exam->isFull()) {
            return back()->with('error', 'عذراً، امتلأت أماكن هذا الامتحان.');
        }

        // Check time conflict for same student (by phone)
        $conflict = ExamRegistration::where('phone', $request->phone)
            ->whereHas('exam', function ($q) use ($exam) {
                $q->where('exam_date', $exam->exam_date)
                  ->where('start_time', '<', $exam->end_time)
                  ->where('end_time', '>', $exam->start_time);
            })->exists();

        if ($conflict) {
            return back()->with('error', 'لديك تسجيل في امتحان آخر بنفس الوقت.');
        }

        ExamRegistration::create($request->only('exam_id', 'student_name', 'country', 'email', 'phone'));
        return back()->with('success', 'تم تسجيلك في الامتحان بنجاح! سيتم التواصل معك قريباً.');
    }
}
