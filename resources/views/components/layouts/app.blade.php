<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ isset($title) ? $title.' | ' : '' }}{{ config('app.name', 'Business Analyzer') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/scss/app.scss', 'resources/js/app.js'])
        @endif

        @livewireStyles
    </head>
    <body>
        <div class="app-shell">
            <header class="site-header">
                <div class="site-header__inner">
                    <a href="{{ route('public.home') }}" class="brand" aria-label="Business Analyzer home">
                        <span class="brand__mark">
                            BA
                        </span>
                        <span class="brand__copy">
                            <span class="brand__name">Business Analyzer</span>
                            <span class="brand__meta">Operational intelligence</span>
                        </span>
                    </a>

                    <nav class="site-nav" aria-label="Main navigation">
                        <a class="site-nav__link {{ request()->routeIs('public.home') || request()->routeIs('public.about') ? 'is-active' : '' }}" href="{{ route('public.home') }}">About</a>
                        <a class="site-nav__link {{ request()->routeIs('public.request') ? 'is-active' : '' }}" href="{{ route('public.request') }}">Request</a>
                        <a class="site-nav__link {{ request()->routeIs('public.contact') ? 'is-active' : '' }}" href="{{ route('public.contact') }}">Contact</a>
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
