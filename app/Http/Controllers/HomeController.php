<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\{Exam, Course, Field};

class HomeController extends Controller
{
    public function index()
    {
        $locale = Session::get('locale', 'ar');
        App::setLocale($locale);

        $exams = Exam::with('subject.field')
            ->withCount('registrations')
            ->where('status', 'announced')
            ->where('exam_date', '>=', date('Y-m-d'))
            ->orderBy('exam_date', 'asc')
            ->get();

        $courses = Course::with(['field', 'teachers'])
            ->withCount('registrations')
            ->where('is_visible', true)
            ->where('end_date', '>=', date('Y-m-d'))
            ->orderBy('start_date', 'asc')
            ->get();

        $fields = Field::orderBy('name')->get();

        return view('home', compact('locale', 'exams', 'courses', 'fields'));
    }

    public function courses(Request $request)
    {
        $locale = Session::get('locale', 'ar');
        App::setLocale($locale);
        $search = $request->input('q', '');

        $courses = Course::with(['field', 'teachers'])
            ->withCount('registrations')
            ->where('is_visible', true)
            ->where('end_date', '>=', date('Y-m-d'))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhereHas('field', fn($f) => $f->where('name', 'like', "%{$search}%"))
                      ->orWhereHas('teachers', fn($t) => $t->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('start_date', 'asc')
            ->paginate(12)
            ->withQueryString();

        return view('pages.courses', compact('locale', 'courses', 'search'));
    }

    public function exams(Request $request)
    {
        $locale = Session::get('locale', 'ar');
        App::setLocale($locale);
        $search = $request->input('q', '');

        $exams = Exam::with('subject.field')
            ->withCount('registrations')
            ->where('status', 'announced')
            ->where('exam_date', '>=', date('Y-m-d'))
            ->when($search, function ($query) use ($search) {
                $query->whereHas('subject', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhereHas('field', fn($f) => $f->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('exam_date', 'asc')
            ->paginate(12)
            ->withQueryString();

        return view('pages.exams', compact('locale', 'exams', 'search'));
    }
}
