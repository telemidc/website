<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)
    ->handle(\Illuminate\Http\Request::capture());

$logoPath = public_path('assets/logo.jpg');

$html = \Illuminate\Support\Facades\View::make('admin.certificates.pdf', [
    'certificate' => (object)[
        'certificate_number' => 'CRD-2025-0001',
        'grade'    => 'ممتاز',
        'issued_at' => '2025-05-13',
        'registration' => (object)[
            'student_name' => 'أحمد محمد علي',
            'course' => (object)[
                'name' => 'دورة تطبيقات الويب باستخدام Laravel 11',
            ],
        ],
    ],
])->render();

$tempDir = __DIR__ . '/storage/temp/mpdf';
if (!is_dir($tempDir)) mkdir($tempDir, 0755, true);

$defaultConfig     = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();

$mpdf = new \Mpdf\Mpdf([
    'mode'             => 'utf-8',
    'format'           => 'A4-L',
    'tempDir'          => $tempDir,
    'fontDir'          => array_merge($defaultConfig['fontDir'], [__DIR__ . '/storage/fonts']),
    'fontdata'         => $defaultFontConfig['fontdata'],
    'default_font'     => 'xbriyaz',
    'autoScriptToLang' => true,
    'autoLangToFont'   => true,
    'useOTL'           => 0xFF,
]);

// Check rendered HTML for the img tag
preg_match('/<img[^>]*logo[^>]*>/i', $html, $imgTag);
echo "img tag in HTML: " . ($imgTag[0] ?? 'NOT FOUND') . "\n";
preg_match('/src="([^"]*)"/', $imgTag[0] ?? '', $src);
echo "src value: " . ($src[1] ?? 'NOT FOUND') . "\n\n";

// --- NO LOGO baseline ---
$mpdf->WriteHTML($html);
$pages = $mpdf->page;
$out_nologo = __DIR__ . '/storage/test_cert_nologo.pdf';
$mpdf->Output($out_nologo, 'F');
$baseline = filesize($out_nologo);
echo "No-logo size: $baseline bytes\n";

// --- WITH LOGO (new mpdf instance) ---
$mpdf2 = new \Mpdf\Mpdf([
    'mode'             => 'utf-8',
    'format'           => 'A4-L',
    'tempDir'          => $tempDir,
    'fontDir'          => array_merge($defaultConfig['fontDir'], [__DIR__ . '/storage/fonts']),
    'fontdata'         => $defaultFontConfig['fontdata'],
    'default_font'     => 'xbriyaz',
    'autoScriptToLang' => true,
    'autoLangToFont'   => true,
    'useOTL'           => 0xFF,
]);

if (file_exists($logoPath)) {
    $mpdf2->imageVars['logoimg'] = file_get_contents($logoPath);
    echo "Logo JPEG: " . filesize($logoPath) . " bytes — imageVars set\n";
}

$mpdf2->WriteHTML($html);
$out = __DIR__ . '/storage/test_cert_v5.pdf';
$mpdf2->Output($out, 'F');
$withLogo = filesize($out);
$diff = $withLogo - $baseline;
echo "With-logo size: $withLogo bytes\n";
echo "Diff: +$diff bytes\n";
echo ($diff > 5000 ? "✓ LOGO INCLUDED" : "✗ LOGO MISSING (check output visually)") . "\n";
echo "Pages: " . $mpdf2->page . "\n";
