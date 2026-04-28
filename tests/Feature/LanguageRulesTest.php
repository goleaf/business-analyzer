<?php

namespace Tests\Feature;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use Tests\TestCase;

class LanguageRulesTest extends TestCase
{
    private const CYRILLIC_CHARACTER_PATTERN = '/\p{Cyrillic}/u';

    public function test_project_text_does_not_contain_russian_characters(): void
    {
        $paths = [
            app_path(),
            config_path(),
            database_path('factories'),
            database_path('migrations'),
            resource_path('views'),
            base_path('routes'),
            base_path('.env.example'),
        ];

        foreach ($paths as $path) {
            if (is_file($path)) {
                $this->assertDoesNotMatchRegularExpression(self::CYRILLIC_CHARACTER_PATTERN, file_get_contents($path), $path);
                continue;
            }

            $files = new RegexIterator(
                new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)),
                '/\.(php|blade\.php|env)$/'
            );

            foreach ($files as $file) {
                $contents = file_get_contents($file->getPathname());

                $this->assertDoesNotMatchRegularExpression(self::CYRILLIC_CHARACTER_PATTERN, $contents, $file->getPathname());
            }
        }
    }
}
