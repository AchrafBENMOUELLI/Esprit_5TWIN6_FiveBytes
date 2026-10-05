<?php

namespace App\Services\Quality;

use App\Models\Quality\QualityAlert;

class QualityAlertService
{
    public function update(QualityAlert $alert, array $data): QualityAlert
    {
        $alert->update([
            'message' => $data['message'] ?? $alert->message,
            'publiee' => $data['publiee'] ?? $alert->publiee,
        ]);

        return $alert->fresh();
    }

    public function resolve(QualityAlert $alert): QualityAlert
    {
        $alert->update([
            'date_resolution' => now(),
        ]);

        return $alert->fresh();
    }

    public function publish(QualityAlert $alert): QualityAlert
    {
        $alert->update([
            'publiee' => true,
        ]);

        return $alert->fresh();
    }
}
