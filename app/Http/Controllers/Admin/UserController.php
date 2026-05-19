<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index() {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6',
        ]);
        User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => true,
        ]);
        return back()->with('success', 'تم إضافة حساب المدير بنجاح.');
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
        ]);
        $user->name = $request->name;
        $user->phone = $request->phone;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return back()->with('success', 'تم تعديل بيانات الحساب بنجاح.');
    }

    public function destroy(User $user) {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'لا يمكنك حذف حسابك الخاص أثناء تسجيل الدخول.');
        }
        $user->delete();
        return back()->with('success', 'تم حذف الحساب بنجاح.');
    }
}
