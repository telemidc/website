<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Course, Field, TeacherApplication};
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index() {
        $courses  = Course::with(['field', 'teachers'])->withCount('registrations')->latest()->get();
        $fields   = Field::orderBy('name')->get();
        $teachers = TeacherApplication::where('status', 'hired')->orderBy('name')->get();
        return view('admin.courses.index', compact('courses', 'fields', 'teachers'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'         => 'required|string|max:255',
            'field_id'     => 'required|exists:fields,id',
            'description'  => 'nullable|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after:start_date',
            'max_students' => 'required|integer|min:1',
            'teachers'     => 'nullable|array',
            'teachers.*'   => 'exists:teacher_applications,id',
        ]);
        $course = Course::create($request->only('name', 'field_id', 'description', 'start_date', 'end_date', 'max_students'));
        if ($request->teachers) {
            $course->teachers()->sync($request->teachers);
        }
        return back()->with('success', 'تم إضافة الدورة بنجاح.');
    }

    public function update(Request $request, Course $course) {
        $request->validate([
            'name'         => 'required|string|max:255',
            'field_id'     => 'required|exists:fields,id',
            'description'  => 'nullable|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after:start_date',
            'max_students' => 'required|integer|min:1',
            'teachers'     => 'nullable|array',
            'teachers.*'   => 'exists:teacher_applications,id',
        ]);
        $course->update($request->only('name', 'field_id', 'description', 'start_date', 'end_date', 'max_students'));
        $course->teachers()->sync($request->teachers ?? []);
        return back()->with('success', 'تم تعديل الدورة بنجاح.');
    }

    public function toggleVisibility(Course $course) {
        $course->update(['is_visible' => !$course->is_visible]);
        $msg = $course->is_visible ? 'تم إظهار الدورة للمستخدمين.' : 'تم إخفاء الدورة عن المستخدمين.';
        return back()->with('success', $msg);
    }

    public function destroy(Course $course) {
        if ($course->registrations()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الدورة لأن هناك طلاباً مسجلين فيها. يمكنك إخفاؤها بدلاً من ذلك.');
        }
        $course->delete();
        return back()->with('success', 'تم حذف الدورة بنجاح.');
    }

    public function registrations(Request $request, Course $course) {
        $query = $course->registrations()->latest();
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('student_name', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%");
            });
        }
        $registrations = $query->paginate(25);
        return view('admin.courses.registrations', compact('course', 'registrations'));
    }
}
