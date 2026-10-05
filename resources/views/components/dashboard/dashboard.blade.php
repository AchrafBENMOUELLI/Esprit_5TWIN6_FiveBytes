<style>{!! file_get_contents(resource_path('views/components/dashboard/dashboard.css')) !!}</style>

<x-dashboard.dashboardsidebar />
<x-dashboard.dashboardnavbar />

<main class="aq-dash-main">
    @if (in_array(request('module'), ['infrastructure', 'incident', 'quality', 'drought', 'project']))
        <x-dynamic-component :component="request('module') . '.' . request('module')" />
    @else
        <h1>Tableau de bord</h1>
        <p>Bienvenue {{ auth()->user()->name }}.</p>
    @endif
</main>
