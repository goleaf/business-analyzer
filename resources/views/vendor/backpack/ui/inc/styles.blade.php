@basset(base_path('node_modules/animate.css/animate.compat.css'))
@basset(base_path('node_modules/noty/lib/noty.css'))

@basset(base_path('node_modules/line-awesome/dist/line-awesome/css/line-awesome.min.css'))
@basset(base_path('node_modules/line-awesome/dist/line-awesome/fonts/la-regular-400.woff2'))
@basset(base_path('node_modules/line-awesome/dist/line-awesome/fonts/la-solid-900.woff2'))
@basset(base_path('node_modules/line-awesome/dist/line-awesome/fonts/la-brands-400.woff2'))
@basset(base_path('node_modules/line-awesome/dist/line-awesome/fonts/la-regular-400.woff'))
@basset(base_path('node_modules/line-awesome/dist/line-awesome/fonts/la-solid-900.woff'))
@basset(base_path('node_modules/line-awesome/dist/line-awesome/fonts/la-brands-400.woff'))
@basset(base_path('node_modules/line-awesome/dist/line-awesome/fonts/la-regular-400.ttf'))
@basset(base_path('node_modules/line-awesome/dist/line-awesome/fonts/la-solid-900.ttf'))
@basset(base_path('node_modules/line-awesome/dist/line-awesome/fonts/la-brands-400.ttf'))

@basset(base_path('vendor/backpack/crud/src/resources/assets/css/common.css'))

@if (backpack_theme_config('styles') && count(backpack_theme_config('styles')))
    @foreach (backpack_theme_config('styles') as $path)
        @if (is_array($path))
            @basset(...$path)
        @else
            @basset($path)
        @endif
    @endforeach
@endif

@if (backpack_theme_config('mix_styles') && count(backpack_theme_config('mix_styles')))
    @foreach (backpack_theme_config('mix_styles') as $path => $manifest)
        <link rel="stylesheet" type="text/css" href="{{ mix($path, $manifest) }}">
    @endforeach
@endif

@if (backpack_theme_config('vite_styles') && count(backpack_theme_config('vite_styles')))
    @vite(backpack_theme_config('vite_styles'))
@endif
