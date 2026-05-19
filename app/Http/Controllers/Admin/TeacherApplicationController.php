<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{TeacherApplication, TeacherContract, Field};
use Illuminate\Http\Request;

class TeacherApplicationController extends Controller
{
    public function index(Request $request) {
        $query = TeacherApplication::with(['field', 'contract'])->latest();
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
            });
        }
        $applications = $query->get();
        $fields = Field::orderBy('name')->get();
        return view('admin.teachers.index', compact('applications', 'fields'));
    }

    public function updateStatus(Request $request, TeacherApplication $teacher) {
        $request->validate(['status' => 'required|in:pending,hired,rejected']);
        $teacher->update(['status' => $request->status]);
        return back()->with('success', 'تم تحديث حالة الطلب.');
    }

    public function hire(Request $request, TeacherApplication $teacher) {
        $request->validate([
            'contract_duration' => 'required|string',
            'contract_text'     => 'required|string',
            'salary'            => 'required|numeric|min:0',
            'start_date'        => 'required|date',
        ]);
        $teacher->update(['status' => 'hired']);
        TeacherContract::updateOrCreate(
            ['teacher_application_id' => $teacher->id],
            $request->only('contract_duration', 'contract_text', 'salary', 'start_date')
        );
        return back()->with('success', 'تم توظيف الأستاذ وحفظ العقد بنجاح.');
    }

    public function storeDirect(Request $request) {
        $request->validate([
            'name'              => 'required|string|max:255',
            'field_id'          => 'required|exists:fields,id',
            'phone'             => 'required|string|max:20',
            'email'             => 'required|email',
            'bio'               => 'nullable|string',
            'contract_duration' => 'required|string',
            'contract_text'     => 'required|string',
            'salary'            => 'required|numeric|min:0',
            'start_date'        => 'required|date',
        ]);

        $teacher = TeacherApplication::create([
            'name'     => $request->name,
            'field_id' => $request->field_id,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'bio'      => $request->bio ?? 'أستاذ مضاف من قبل الإدارة',
            'status'   => 'hired'
        ]);

        TeacherContract::create([
            'teacher_application_id' => $teacher->id,
            'contract_duration'      => $request->contract_duration,
            'contract_text'          => $request->contract_text,
            'salary'                 => $request->salary,
            'start_date'             => $request->start_date,
        ]);

        return back()->with('success', 'تم إضافة الأستاذ المباشر وتوثيق عقده بنجاح.');
    }
}
