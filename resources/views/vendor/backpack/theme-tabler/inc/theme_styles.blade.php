{{--
    We use a render-blocking script in <head> to force the theme attribute to be
    in the document before it renders, avoiding white flickers in dark mode.
--}}
<script>document.documentElement.setAttribute("data-bs-theme", localStorage.colorMode ?? 'light');</script>

@basset(base_path('node_modules/@tabler/core/dist/css/tabler.min.css'))
@basset(base_path('vendor/backpack/theme-tabler/resources/assets/css/style.css'))
@basset(base_path('vendor/backpack/theme-tabler/resources/assets/css/color-adjustments.css'))
