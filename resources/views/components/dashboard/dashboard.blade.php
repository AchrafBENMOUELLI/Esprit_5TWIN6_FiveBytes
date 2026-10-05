@props(['module' => null, 'samples' => collect()])

<style>{!! file_get_contents(resource_path('views/components/dashboard/dashboard.css')) !!}</style>

<x-dashboard.dashboardsidebar />
<x-dashboard.dashboardnavbar />

<main class="aq-dash-main">
    @if ($module === 'quality')
        <x-quality.quality :samples="$samples" />
    @elseif (in_array($module, ['infrastructure', 'incident', 'drought', 'project']))
        <x-dynamic-component :component="$module . '.' . $module" />
    @else
        <h1>Tableau de bord</h1>
        <p>Bienvenue {{ auth()->user()->name }}.</p>
    @endif
</main>
