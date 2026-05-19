<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Certificate, CourseRegistration};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(Request $request) {
        $query = $request->input('q', '');

        $certificates = Certificate::with('registration.course')
            ->when($query, function ($q) use ($query) {
                $q->where('certificate_number', 'like', "%{$query}%")
                  ->orWhereHas('registration', function ($r) use ($query) {
                      $r->where('student_name', 'like', "%{$query}%");
                  });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.certificates.index', compact('certificates', 'query'));
    }

    public function create(Request $request) {
        $registration = CourseRegistration::with('course')->findOrFail($request->registration_id);
        return view('admin.certificates.create', compact('registration'));
    }

    public function store(Request $request) {
        $request->validate([
            'course_registration_id' => 'required|exists:course_registrations,id',
            'grade'                  => 'required|string|max:50',
            'notes'                  => 'nullable|string',
            'issued_at'              => 'required|date',
        ]);
        $existing = Certificate::where('course_registration_id', $request->course_registration_id)->first();
        if ($existing) {
            return back()->with('error', 'هذا الطالب لديه شهادة مُصدرة مسبقاً لهذه الدورة.');
        }
        Certificate::create($request->only('course_registration_id', 'grade', 'notes', 'issued_at'));
        return redirect()->route('admin.certificates.index')->with('success', 'تم إصدار الشهادة بنجاح.');
    }

    public function downloadPdf(Certificate $certificate) {
        $certificate->load('registration.course.field');
        $filename = 'certificate-' . $certificate->certificate_number . '.pdf';

        // Prefer mPDF for proper Arabic shaping when available
        if (class_exists(\Mpdf\Mpdf::class)) {
            $logoPath  = public_path('assets/logo.jpg');
            $hasLogo   = file_exists($logoPath);

            $html = view('admin.certificates.pdf', compact('certificate'))->render();

            $tempDir = storage_path('temp/mpdf');
            if (!is_dir($tempDir)) { @mkdir($tempDir, 0755, true); }

            $defaultConfig     = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();

            $mpdf = new \Mpdf\Mpdf([
                'mode'             => 'utf-8',
                'format'           => 'A4-L',
                'tempDir'          => $tempDir,
                'fontDir'          => array_merge($defaultConfig['fontDir'], [storage_path('fonts')]),
                'fontdata'         => $defaultFontConfig['fontdata'],
                'default_font'     => 'xbriyaz',
                'autoScriptToLang' => true,
                'autoLangToFont'   => true,
                'useOTL'           => 0xFF,
            ]);

            if ($hasLogo) {
                $mpdf->imageVars['logoimg'] = file_get_contents($logoPath);
            }

            $mpdf->WriteHTML($html);
            $content = $mpdf->Output($filename, 'S');
            return response($content, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        // Fallback to DomPDF
        $pdf = Pdf::loadView('admin.certificates.pdf', compact('certificate'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download($filename);
    }

    public function search(Request $request) {
        $cert = null;
        if ($request->filled('number')) {
            $cert = Certificate::with('registration.course')
                ->where('certificate_number', $request->number)->first();
        }
        return view('admin.certificates.search', compact('cert'));
    }
}
