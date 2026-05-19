<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require 'vendor/autoload.php';

$tempDir = __DIR__ . '/storage/temp/mpdf';
if (!is_dir($tempDir)) mkdir($tempDir, 0755, true);

$defaultConfig     = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();

$mpdf = new \Mpdf\Mpdf([
    'mode'    => 'utf-8',
    'format'  => 'A4-L',
    'tempDir' => $tempDir,
    'fontDir' => $defaultConfig['fontDir'],
    'fontdata'=> $defaultFontConfig['fontdata'],
]);

$logoPath = __DIR__ . '/public/assets/logo.jpg'; // try JPEG
$mpdf->imageVars['logoimg'] = file_get_contents($logoPath);
echo "imageVars['logoimg'] size: " . strlen($mpdf->imageVars['logoimg']) . " bytes (JPEG)\n";

// Test 1: simple HTML with logo
$html1 = '<html><body><img src="var:logoimg" style="height:14mm;width:auto;" /><p>Hello Arabic</p></body></html>';
$mpdf->WriteHTML($html1);
$out1 = __DIR__ . '/storage/test_logo_simple.pdf';
$mpdf->Output($out1, 'F');
echo "Test1 (simple+logo): " . filesize($out1) . " bytes " . (filesize($out1) > 50000 ? "✓ HAS LOGO" : "✗ NO LOGO") . "\n";

// Test 2: exact same mPDF config as production, simple HTML
$mpdf2 = new \Mpdf\Mpdf([
    'mode'             => 'utf-8',
    'format'           => 'A4-L',
    'tempDir'          => $tempDir,
    'fontDir'          => $defaultConfig['fontDir'],
    'fontdata'         => $defaultFontConfig['fontdata'],
    'default_font'     => 'xbriyaz',
    'autoScriptToLang' => true,
    'autoLangToFont'   => true,
    'useOTL'           => 0xFF,
]);
$mpdf2->imageVars['logoimg'] = file_get_contents(__DIR__ . '/public/assets/logo.jpg');
$html2 = '<html><head><style>* { margin:0; padding:0; } body { padding:7mm; font-family:xbriyaz; }</style></head><body>
  <img src="var:logoimg" style="height:14mm;" />
  <p style="direction:rtl; unicode-bidi:bidi-override;">أحمد محمد علي</p>
</body></html>';
$mpdf2->WriteHTML($html2);
$out2 = __DIR__ . '/storage/test_logo_otl.pdf';
$mpdf2->Output($out2, 'F');
echo "Test2 (OTL config+logo): " . filesize($out2) . " bytes " . (filesize($out2) > 30000 ? "✓ HAS LOGO" : "✗ NO LOGO") . "\n";
