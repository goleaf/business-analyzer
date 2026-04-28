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
            app_path('Filament'),
            app_path('Providers/Filament'),
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

    public function test_package_manifest_has_no_removed_admin_asset_packages(): void
    {
        $manifest = json_decode((string) file_get_contents(base_path('package.json')), true, flags: JSON_THROW_ON_ERROR);
        $dependencies = array_keys($manifest['dependencies'] ?? []);

        $this->assertEmpty(array_intersect($dependencies, [
            '@tabler/core',
            'datatables.net',
            'jquery',
            'line-awesome',
            'noty',
            'sweetalert',
        ]));
    }

    public function test_public_frontend_uses_scss_entrypoint_only(): void
    {
        $manifest = json_decode((string) file_get_contents(base_path('package.json')), true, flags: JSON_THROW_ON_ERROR);
        $frontendPackages = array_keys(array_merge(
            $manifest['dependencies'] ?? [],
            $manifest['devDependencies'] ?? [],
        ));

        $viteConfig = (string) file_get_contents(base_path('vite.config.js'));
        $layout = (string) file_get_contents(resource_path('views/components/layouts/app.blade.php'));

        $this->assertFileExists(resource_path('scss/app.scss'));
        $this->assertFileDoesNotExist(resource_path('css/app.css'));
        $this->assertStringContainsString('resources/scss/app.scss', $viteConfig);
        $this->assertStringContainsString('resources/scss/app.scss', $layout);
        $this->assertStringNotContainsString('resources/css/app.css', $viteConfig);
        $this->assertEmpty(array_intersect($frontendPackages, [
            '@tailwindcss/vite',
            'tailwindcss',
            'bootstrap',
        ]));
    }
}
