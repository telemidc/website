<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use FontLib\Font;

class InstallArabicFont extends Command
{
    protected $signature = 'font:install-arabic';
    protected $description = 'Install Amiri Arabic font for DomPDF';

    public function handle(): int
    {
        $fontDir = storage_path('fonts');
        if (!is_dir($fontDir)) {
            mkdir($fontDir, 0755, true);
        }

        $regularPath = $fontDir . '/Amiri-Regular.ttf';
        $boldPath = $fontDir . '/Amiri-Bold.ttf';

        if (!file_exists($regularPath) || !file_exists($boldPath)) {
            $this->error('Font files not found in storage/fonts/.');
            $this->error('Please place Amiri-Regular.ttf and Amiri-Bold.ttf there.');
            return 1;
        }

        $normalBase = 'amiri_normal_' . md5($regularPath);
        $boldBase = 'amiri_bold_' . md5($boldPath);

        // Generate UFM font metrics using FontLib
        $this->info('Generating font metrics...');

        $font = Font::load($regularPath);
        $font->parse();
        $font->saveAdobeFontMetrics($fontDir . '/' . $normalBase . '.ufm');
        $font->close();
        $this->info('  Normal UFM: OK');

        $fontBold = Font::load($boldPath);
        $fontBold->parse();
        $fontBold->saveAdobeFontMetrics($fontDir . '/' . $boldBase . '.ufm');
        $fontBold->close();
        $this->info('  Bold UFM: OK');

        // Copy TTF with DomPDF-expected naming
        copy($regularPath, $fontDir . '/' . $normalBase . '.ttf');
        copy($boldPath, $fontDir . '/' . $boldBase . '.ttf');
        $this->info('  TTF copies: OK');

        // Update installed-fonts.json
        $installedFontsFile = $fontDir . '/installed-fonts.json';
        $existingFonts = [];
        if (file_exists($installedFontsFile)) {
            $existingFonts = json_decode(file_get_contents($installedFontsFile), true) ?: [];
        }

        $existingFonts['amiri'] = [
            'normal' => $normalBase,
            'bold' => $boldBase,
        ];

        file_put_contents($installedFontsFile, json_encode($existingFonts, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->info('  installed-fonts.json: OK');

        $this->newLine();
        $this->info('Amiri Arabic font installed successfully for DomPDF!');
        $this->info("Use font-family: 'amiri' in your CSS.");
        return 0;
    }
}
