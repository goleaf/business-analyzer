<?php

namespace Tests\Feature;

use App\Filament\Resources\AiPrompts\AiPromptResource;
use App\Filament\Resources\ContactSubmissions\ContactSubmissionResource;
use App\Filament\Resources\RequestSubmissions\RequestSubmissionResource;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Tests\TestCase;

class AdminStackTest extends TestCase
{
    public function test_admin_stack_is_filament_only(): void
    {
        $composer = $this->jsonFile(base_path('composer.json'));

        $this->assertArrayHasKey('filament/filament', $composer['require'] ?? []);
        $this->assertNoAdminPackagesFromRemovedStack(array_keys($composer['require'] ?? []));
        $this->assertNoAdminPackagesFromRemovedStack(array_keys($composer['require-dev'] ?? []));

        $lockPath = base_path('composer.lock');

        if (file_exists($lockPath)) {
            $lock = $this->jsonFile($lockPath);
            $lockedPackages = collect($lock['packages'] ?? [])
                ->merge($lock['packages-dev'] ?? [])
                ->pluck('name')
                ->all();

            $this->assertNoAdminPackagesFromRemovedStack($lockedPackages);
        }
    }

    public function test_filament_resources_cover_the_admin_domain(): void
    {
        $this->assertSame('/admin/request-submissions', RequestSubmissionResource::getUrl('index', isAbsolute: false));
        $this->assertSame('/admin/contact-submissions', ContactSubmissionResource::getUrl('index', isAbsolute: false));
        $this->assertSame('/admin/ai-prompts', AiPromptResource::getUrl('index', isAbsolute: false));
    }

    public function test_application_source_has_no_removed_admin_stack_artifacts(): void
    {
        $removedVendor = 'back'.'pack';
        $removedStudly = 'Back'.'pack';

        $forbiddenNeedles = [
            $removedVendor,
            $removedStudly,
            'route::crud',
            'crudcontroller',
            'crudpanel',
            'crudtrait',
            'backpack_url',
            'admin_url',
            'crud::',
            'backpack::',
        ];

        foreach ($this->applicationSourceFiles() as $file) {
            $contents = strtolower((string) file_get_contents($file->getPathname()));

            foreach ($forbiddenNeedles as $needle) {
                $this->assertStringNotContainsString(
                    strtolower($needle),
                    $contents,
                    sprintf('Removed admin stack artifact [%s] found in [%s].', $needle, $file->getPathname()),
                );
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function jsonFile(string $path): array
    {
        return json_decode((string) file_get_contents($path), associative: true, flags: JSON_THROW_ON_ERROR);
    }

    /**
     * @param  array<int, string>  $packages
     */
    private function assertNoAdminPackagesFromRemovedStack(array $packages): void
    {
        $removedVendor = 'back'.'pack';

        foreach ($packages as $package) {
            $this->assertStringNotContainsString(
                $removedVendor,
                strtolower($package),
                sprintf('Removed admin stack package [%s] is still installed.', $package),
            );
        }
    }

    /**
     * @return iterable<SplFileInfo>
     */
    private function applicationSourceFiles(): iterable
    {
        $paths = [
            base_path('app'),
            base_path('config'),
            base_path('database'),
            base_path('resources'),
            base_path('routes'),
            base_path('composer.json'),
            base_path('composer.lock'),
        ];

        foreach ($paths as $path) {
            if (is_file($path)) {
                yield new SplFileInfo($path);

                continue;
            }

            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            );

            foreach ($iterator as $file) {
                if ($file instanceof SplFileInfo && $file->isFile()) {
                    yield $file;
                }
            }
        }
    }
}
