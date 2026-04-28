<?php

namespace Tests\Feature;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use Tests\TestCase;

class FrontendAssetPolicyTest extends TestCase
{
    public function test_css_and_js_assets_do_not_use_remote_urls(): void
    {
        $paths = [
            config_path('backpack'),
            resource_path('views'),
        ];

        $remoteAssetPattern = '/(?:@basset\(\s*[\'"]https?:\/\/|<script\b[^>]*\bsrc=[\'"]https?:\/\/|<link\b(?=[^>]*\brel=[\'"][^\'"]*stylesheet)(?=[^>]*\bhref=[\'"]https?:\/\/)|<link\b(?=[^>]*\bhref=[\'"]https?:\/\/)(?=[^>]*\brel=[\'"][^\'"]*stylesheet))/i';

        foreach ($paths as $path) {
            $files = new RegexIterator(
                new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)),
                '/\.(php|blade\.php)$/'
            );

            foreach ($files as $file) {
                $contents = file_get_contents($file->getPathname());

                $this->assertDoesNotMatchRegularExpression(
                    $remoteAssetPattern,
                    $contents,
                    $file->getPathname()
                );
            }
        }
    }

    public function test_backpack_asset_overrides_use_node_modules(): void
    {
        $overrideFiles = [
            resource_path('views/vendor/backpack/ui/inc/styles.blade.php'),
            resource_path('views/vendor/backpack/ui/inc/scripts.blade.php'),
            resource_path('views/vendor/backpack/theme-tabler/inc/theme_styles.blade.php'),
            resource_path('views/vendor/backpack/theme-tabler/inc/theme_scripts.blade.php'),
            resource_path('views/vendor/backpack/crud/components/datatable/datatable_logic.blade.php'),
        ];

        foreach ($overrideFiles as $file) {
            $this->assertFileExists($file);

            $contents = file_get_contents($file);

            $this->assertStringContainsString('node_modules', $contents, $file);
            $this->assertDoesNotMatchRegularExpression('/https?:\/\/(?:cdn|cdnjs|unpkg|jsdelivr|fonts\.)/i', $contents, $file);
        }
    }
}
