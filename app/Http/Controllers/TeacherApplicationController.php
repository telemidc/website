<?php
namespace App\Http\Controllers;
use App\Models\{TeacherApplication, Field};
use Illuminate\Http\Request;

class TeacherApplicationController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'field_id' => 'required|exists:fields,id',
            'phone'    => 'required|string|max:20',
            'bio'      => 'required|string|max:1000',
            'email'    => 'required|email',
        ]);
        TeacherApplication::create($request->only('name', 'field_id', 'phone', 'bio', 'email'));
        return back()->with('teacher_success', 'تم إرسال طلبك بنجاح! سيتم مراجعته والتواصل معك.');
    }
}
