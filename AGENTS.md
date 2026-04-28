# AGENTS.md - Business Analyzer

## Filament Admin Defaults

- Use Filament for all admin UI. Do not add Backpack or Backpack-style CRUD artifacts.
- Keep the Filament admin panel in top navigation, light mode only, and full-width content.
- Configure these panel defaults in `App\Providers\Filament\AdminPanelProvider`: `topNavigation()`, `darkMode(false)`, `defaultThemeMode(ThemeMode::Light)`, `maxContentWidth(Width::Full)`, and `resourceCreatePageRedirect('edit')`.
- Records should open edit pages by default. Do not add view pages or infolist-only view modes unless explicitly requested.
- Do not add Filament table bulk actions.
- AI prompt ordering is drag-and-drop through the existing `sort_order` column. Do not expose a numeric sort-order field or table column for manual ordering.
- Verify Filament API changes against current Filament documentation through MCP before changing admin resources, panels, tables, or forms.

## Public Frontend Defaults

- Build public pages with Laravel Blade, Livewire, and SCSS only. Do not add Tailwind, React, Vue, Inertia, jQuery, Bootstrap, or remote CSS/JS frameworks.
- Keep public styling in `resources/scss/app.scss` using shared SCSS variables, maps, functions, and mixins before adding one-off selectors.
- Keep public pages image-led, conversion-focused, and business-optimization oriented.
- Use local visual assets under `public/images` instead of remote scripts, stylesheets, or third-party brand assets.
- Preserve Livewire forms for request and contact submissions.
- Research current business/process optimization site patterns before major public frontend redesigns, then create original layouts rather than copying proprietary branding or assets.
