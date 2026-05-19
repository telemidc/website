<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Exam, Subject, ExamRegistration, Certificate};
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index() {
        $exams = Exam::with('subject.field')->withCount('registrations')->latest('exam_date')->get();
        $subjects = Subject::with('field')->orderBy('name')->get();
        return view('admin.exams.index', compact('exams', 'subjects'));
    }

    public function store(Request $request) {
        $request->validate([
            'subject_id'   => 'required|exists:subjects,id',
            'exam_date'    => 'required|date',
            'start_time'   => 'required',
            'end_time'     => 'required',
            'max_students' => 'required|integer|min:1',
        ]);
        Exam::create($request->only('subject_id', 'exam_date', 'start_time', 'end_time', 'max_students'));
        return back()->with('success', 'تم إضافة الامتحان بنجاح.');
    }

    public function update(Request $request, Exam $exam) {
        $request->validate([
            'subject_id'   => 'required|exists:subjects,id',
            'exam_date'    => 'required|date',
            'start_time'   => 'required',
            'end_time'     => 'required',
            'max_students' => 'required|integer|min:1',
        ]);
        $exam->update($request->only('subject_id', 'exam_date', 'start_time', 'end_time', 'max_students'));
        return back()->with('success', 'تم تعديل الامتحان بنجاح.');
    }

    public function destroy(Exam $exam) {
        if ($exam->registrations()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف هذا الامتحان لوجود طلاب مسجلين فيه.');
        }
        $exam->delete();
        return back()->with('success', 'تم حذف الامتحان بنجاح.');
    }

    public function registrations(Request $request, Exam $exam) {
        $query = $exam->registrations()->with('certificate')->latest();
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('student_name', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%");
            });
        }
        $registrations = $query->paginate(25);
        return view('admin.exams.registrations', compact('exam', 'registrations'));
    }

    // Toggle exam status: announced ↔ completed
    public function toggleStatus(Exam $exam) {
        $newStatus = $exam->status === 'announced' ? 'completed' : 'announced';
        $exam->update(['status' => $newStatus]);
        $label = $newStatus === 'completed' ? 'منجز' : 'معلن';
        return back()->with('success', "تم تغيير حالة الامتحان إلى: {$label}.");
    }

    // Results section: search across completed exams
    public function results(Request $request) {
        $exams = Exam::with('subject.field')
            ->where('status', 'completed')
            ->latest('exam_date')
            ->get();

        $selectedExam = null;
        $registrations = collect();

        if ($request->filled('exam_id')) {
            $selectedExam = Exam::with('subject.field')->findOrFail($request->exam_id);
            $query = $selectedExam->registrations()->with('certificate');

            if ($request->filled('search')) {
                $term = $request->search;
                $query->where(function($q) use ($term) {
                    $q->where('student_name', 'like', "%{$term}%")
                      ->orWhere('phone', 'like', "%{$term}%");
                });
            }
            $registrations = $query->latest()->paginate(25)->withQueryString();
        }

        return view('admin.exams.results', compact('exams', 'selectedExam', 'registrations'));
    }

    // Save / update grade & score for a single exam registration
    public function saveGrade(Request $request, ExamRegistration $registration) {
        $request->validate([
            'score' => 'nullable|integer|min:0|max:100',
            'grade' => 'nullable|string|max:50',
        ]);
        $registration->update($request->only('score', 'grade'));
        return back()->with('success', 'تم حفظ التقييم لـ ' . $registration->student_name . '.');
    }

    // Issue a certificate for an exam registration
    public function issueCertificate(Request $request, ExamRegistration $registration) {
        $registration->load('exam.subject', 'certificate');

        if ($registration->certificate) {
            return back()->with('error', 'تم إصدار شهادة لهذا الطالب مسبقاً.');
        }

        if (empty($registration->grade)) {
            return back()->with('error', 'يجب تحديد التقييم أولاً قبل إصدار الشهادة.');
        }

        Certificate::create([
            'exam_registration_id' => $registration->id,
            'course_name'          => $registration->exam->subject->name,
            'grade'                => $registration->grade,
            'issued_at'            => now()->toDateString(),
        ]);

        return back()->with('success', 'تم إصدار شهادة لـ ' . $registration->student_name . ' بنجاح.');
    }
}
