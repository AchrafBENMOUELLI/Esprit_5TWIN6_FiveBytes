<?php

/**
 * Script de test rapide pour vérifier les routes admin
 * 
 * Usage: php tests/test_admin_routes.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 Test des Routes Admin - Module 5\n";
echo "====================================\n\n";

// Récupérer toutes les routes
$routes = Route::getRoutes();
$adminRoutes = [];

foreach ($routes as $route) {
    $uri = $route->uri();
    if (str_starts_with($uri, 'admin/')) {
        $adminRoutes[] = [
            'method' => implode('|', $route->methods()),
            'uri' => $uri,
            'name' => $route->getName(),
            'action' => $route->getActionName(),
        ];
    }
}

// Grouper par contrôleur
$byController = [
    'ProjectController' => [],
    'ContractorController' => [],
    'ProjectPhaseController' => [],
    'FundingController' => [],
    'ProjectDocumentController' => [],
];

foreach ($adminRoutes as $route) {
    foreach ($byController as $controller => &$routes) {
        if (str_contains($route['action'], $controller)) {
            $routes[] = $route;
        }
    }
}

// Afficher les résultats
echo "📊 Statistiques:\n";
echo "----------------\n";
echo "Total routes admin: " . count($adminRoutes) . "\n\n";

foreach ($byController as $controller => $routes) {
    $count = count($routes);
    $icon = $count > 0 ? '✅' : '❌';
    echo "$icon $controller: $count routes\n";
}

echo "\n\n📋 Détail des Routes:\n";
echo "=====================\n\n";

foreach ($byController as $controller => $routes) {
    if (count($routes) > 0) {
        echo "### $controller\n";
        echo str_repeat('-', 80) . "\n";
        
        foreach ($routes as $route) {
            $methods = str_pad($route['method'], 12);
            $uri = str_pad($route['uri'], 40);
            $name = $route['name'] ?? 'N/A';
            
            echo "$methods $uri → $name\n";
        }
        
        echo "\n";
    }
}

// Vérifier les routes critiques
echo "🔍 Vérification Routes Critiques:\n";
echo "==================================\n";

$criticalRoutes = [
    'admin.project.index',
    'admin.project.create',
    'admin.project.store',
    'admin.project.show',
    'admin.project.edit',
    'admin.project.update',
    'admin.project.destroy',
    'admin.contractor.index',
    'admin.phase.create',
    'admin.funding.create',
    'admin.document.store',
    'admin.document.download',
];

$allRouteNames = array_column($adminRoutes, 'name');

foreach ($criticalRoutes as $routeName) {
    $exists = in_array($routeName, $allRouteNames);
    $icon = $exists ? '✅' : '❌';
    echo "$icon $routeName\n";
}

echo "\n\n✅ Test terminé!\n";

if (count($adminRoutes) >= 33) {
    echo "🎉 Toutes les routes admin sont correctement enregistrées!\n";
} else {
    echo "⚠️ Attention: " . (33 - count($adminRoutes)) . " routes manquantes!\n";
}
