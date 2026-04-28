<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ isset($title) ? $title.' | ' : '' }}{{ config('app.name', 'Business Analyzer') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        @livewireStyles
    </head>
    <body class="min-h-screen bg-zinc-50 text-zinc-950 antialiased">
        <div class="min-h-screen">
            <header class="border-b border-zinc-200 bg-white">
                <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:justify-between lg:px-8">
                    <a href="{{ route('public.home') }}" class="text-lg font-semibold tracking-normal text-zinc-950">
                        Business Analyzer
                    </a>

                    <nav class="flex flex-wrap gap-2 text-sm font-medium text-zinc-600" aria-label="Main navigation">
                        <a class="rounded-md px-3 py-2 hover:bg-zinc-100 hover:text-zinc-950" href="{{ route('public.home') }}">About</a>
                        <a class="rounded-md px-3 py-2 hover:bg-zinc-100 hover:text-zinc-950" href="{{ route('public.request') }}">Request</a>
                        <a class="rounded-md px-3 py-2 hover:bg-zinc-100 hover:text-zinc-950" href="{{ route('public.contact') }}">Contact</a>
                    </nav>
                </div>
            </header>

            <main>
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
    </body>
</html>
