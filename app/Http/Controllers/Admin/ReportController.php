<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{CourseRegistration, ExamRegistration, Certificate, TeacherApplication, TeacherContract};
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request) {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $type      = $request->input('type', 'all'); // all, students, certificates, teachers

        $data = $this->getReportData($startDate, $endDate);

        return view('admin.reports.index', compact('startDate', 'endDate', 'type', 'data'));
    }

    public function downloadPdf(Request $request) {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $type      = $request->input('type', 'all');

        $data = $this->getReportData($startDate, $endDate);

        $filename = 'report_' . $startDate . '_to_' . $endDate . '.pdf';

        // Prefer mPDF for better Arabic shaping when available
        if (class_exists(\Mpdf\Mpdf::class)) {
            $html = view('admin.reports.pdf', compact('startDate', 'endDate', 'type', 'data'))->render();

            $tempDir = storage_path('temp/mpdf');
            if (!is_dir($tempDir)) { @mkdir($tempDir, 0755, true); }

            $defaultConfig     = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();

            $mpdf = new \Mpdf\Mpdf([
                'mode'             => 'utf-8',
                'format'           => 'A4',
                'tempDir'          => $tempDir,
                'fontDir'          => array_merge($defaultConfig['fontDir'], [storage_path('fonts')]),
                'fontdata'         => $defaultFontConfig['fontdata'],
                'default_font'     => 'xbriyaz',
                'autoScriptToLang' => true,
                'autoLangToFont'   => true,
                'useOTL'           => 0xFF,
            ]);

            $mpdf->WriteHTML($html);
            $content = $mpdf->Output($filename, 'S');
            return response($content, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        // Fallback to DomPDF
        $pdf = Pdf::loadView('admin.reports.pdf', compact('startDate', 'endDate', 'type', 'data'));
        return $pdf->download($filename);
    }

    private function getReportData($start, $end) {
        // Adjust end date to include the whole day
        $end = Carbon::parse($end)->endOfDay();

        $data = [
            'course_students'   => CourseRegistration::whereBetween('created_at', [$start, $end])->count(),
            'exam_students'     => ExamRegistration::whereBetween('created_at', [$start, $end])->count(),
            'certificates'      => Certificate::whereBetween('created_at', [$start, $end])->count(),
            'teachers_total'    => TeacherApplication::whereBetween('created_at', [$start, $end])->count(),
            'teachers_hired'    => TeacherApplication::where('status', 'hired')->whereBetween('created_at', [$start, $end])->count(),
            'teachers_salaries' => TeacherContract::whereBetween('created_at', [$start, $end])->sum('salary'),
            'recent_courses'    => CourseRegistration::with('course')->whereBetween('created_at', [$start, $end])->latest()->take(5)->get(),
            'recent_exams'      => ExamRegistration::with('exam.subject')->whereBetween('created_at', [$start, $end])->latest()->take(5)->get(),
        ];

        if (request('type') === 'detailed') {
            $data['detailed_courses'] = CourseRegistration::with('course')->whereBetween('created_at', [$start, $end])->get();
            $data['detailed_exams'] = ExamRegistration::with('exam.subject')->whereBetween('created_at', [$start, $end])->get();
            $data['detailed_teachers'] = TeacherApplication::with('field')->where('status', 'hired')->whereBetween('created_at', [$start, $end])->get();
        }

        return $data;
    }
}
