<?php

// Test de l'Observer d'incident
$incident = App\Models\Incident\Incident::first();
echo "Incident: {$incident->reference}\n";
echo "Statut actuel: {$incident->statut->value}\n";
echo "Nombre d'entrées historique avant: " . $incident->statusHistory()->count() . "\n";

$incident->update(['statut' => App\Enums\IncidentStatut::EnCours]);
$incident->refresh();

echo "Statut après update: {$incident->statut->value}\n";
echo "Nombre d'entrées historique après: " . $incident->statusHistory()->count() . "\n";

$lastHistory = $incident->statusHistory()->first();
echo "Dernier changement: {$lastHistory->ancien_statut->value} -> {$lastHistory->nouveau_statut->value}\n";
echo "Modifié par: " . ($lastHistory->modificateur ? $lastHistory->modificateur->name : 'N/A') . "\n";

// Test passage à "resolu"
$incident->update(['statut' => App\Enums\IncidentStatut::Resolu]);
$incident->refresh();

echo "\nTest passage à 'resolu':\n";
echo "Date de résolution: " . ($incident->date_resolution ? $incident->date_resolution->format('Y-m-d H:i:s') : 'NULL') . "\n";

// Test retour en arrière
$incident->update(['statut' => App\Enums\IncidentStatut::EnCours]);
$incident->refresh();

echo "\nTest retour en arrière:\n";
echo "Date de résolution après retour: " . ($incident->date_resolution ? $incident->date_resolution->format('Y-m-d H:i:s') : 'NULL') . "\n";
echo "Nombre total d'entrées historique: " . $incident->statusHistory()->count() . "\n";
