<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Exam;

class HomeController extends Controller
{
    public function index()
    {
        $locale = Session::get('locale', 'ar');
        App::setLocale($locale);

        // Fetch exams where exam_date is today or in the future
        $exams = Exam::where('exam_date', '>=', date('Y-m-d'))
                    ->orderBy('exam_date', 'asc')
                    ->get();

        return view('home', ['locale' => $locale, 'exams' => $exams]);
    }
}
