<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index() {
        $fields = Field::withCount('subjects')->latest()->get();
        return view('admin.fields.index', compact('fields'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']);
        Field::create($request->only('name', 'description'));
        return back()->with('success', 'تم إضافة المجال بنجاح.');
    }

    public function update(Request $request, Field $field) {
        $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']);
        $field->update($request->only('name', 'description'));
        return back()->with('success', 'تم تعديل المجال بنجاح.');
    }

    public function destroy(Field $field) {
        if ($field->subjects()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف المجال لأنه يحتوي على مواد مرتبطة به.');
        }
        $field->delete();
        return back()->with('success', 'تم حذف المجال بنجاح.');
    }
}
