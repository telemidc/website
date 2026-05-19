<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Subject, Field};
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index() {
        $subjects = Subject::with('field')->withCount('exams')->latest()->get();
        $fields   = Field::orderBy('name')->get();
        return view('admin.subjects.index', compact('subjects', 'fields'));
    }

    public function store(Request $request) {
        $request->validate(['field_id' => 'required|exists:fields,id', 'name' => 'required|string|max:255', 'description' => 'nullable|string']);
        Subject::create($request->only('field_id', 'name', 'description'));
        return back()->with('success', 'تم إضافة المادة بنجاح.');
    }

    public function update(Request $request, Subject $subject) {
        $request->validate(['field_id' => 'required|exists:fields,id', 'name' => 'required|string|max:255', 'description' => 'nullable|string']);
        $subject->update($request->only('field_id', 'name', 'description'));
        return back()->with('success', 'تم تعديل المادة بنجاح.');
    }

    public function destroy(Subject $subject) {
        $hasRegistrations = $subject->exams()->whereHas('registrations')->exists();
        if ($hasRegistrations) {
            return back()->with('error', 'لا يمكن حذف المادة لأن هناك طلاباً مسجلين في امتحاناتها.');
        }
        $subject->delete();
        return back()->with('success', 'تم حذف المادة بنجاح.');
    }
}
