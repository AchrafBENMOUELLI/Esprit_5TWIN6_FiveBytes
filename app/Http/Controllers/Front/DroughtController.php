<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drought\StoreSubscriptionRequest;
use App\Models\Drought\Restriction;
use App\Models\Drought\ScheduledCut;
use App\Models\Drought\Subscription;
use App\Models\Infrastructure\Zone;
use Illuminate\Http\Request;

class DroughtController extends Controller
{
    public function dashboard()
    {
        $zones = Zone::all();
        $restrictions = Restriction::where('date_fin', '>=', now())
            ->orWhereNull('date_fin')
            ->latest('date_debut')
            ->get();
        
        return view('front.drought.dashboard', compact('zones', 'restrictions'));
    }

    public function zoneAlerts(Zone $zone)
    {
        $restrictions = $zone->restrictions()
            ->where('date_fin', '>=', now())
            ->orWhereNull('date_fin')
            ->latest('date_debut')
            ->get();
        
        $scheduledCuts = $zone->scheduledCuts()
            ->where('fin', '>=', now())
            ->orderBy('debut')
            ->get();

        return view('front.drought.zone_alerts', compact('zone', 'restrictions', 'scheduledCuts'));
    }

    public function scheduledCuts()
    {
        $cuts = ScheduledCut::where('fin', '>=', now())
            ->with(['zone', 'restriction'])
            ->orderBy('debut')
            ->paginate(15);

        return view('front.drought.scheduled_cuts', compact('cuts'));
    }

    public function mySubscriptions()
    {
        $subscriptions = auth()->user()->subscriptions()->with('zone')->get();
        $allZones = Zone::all();
        
        return view('front.drought.my_subscriptions', compact('subscriptions', 'allZones'));
    }

    public function storeSubscription(StoreSubscriptionRequest $request)
    {
        $exists = Subscription::where('user_id', auth()->id())
            ->where('zone_id', $request->zone_id)
            ->where('canal', $request->canal)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Vous êtes déjà abonné à cette zone avec ce canal.');
        }

        Subscription::create([
            'user_id' => auth()->id(),
            'zone_id' => $request->zone_id,
            'canal' => $request->canal,
            'actif' => true,
        ]);

        return back()->with('success', 'Abonnement ajouté avec succès.');
    }

    public function toggleSubscription(Subscription $subscription)
    {
        if ($subscription->user_id !== auth()->id()) {
            abort(403);
        }

        $subscription->update(['actif' => !$subscription->actif]);
        
        $status = $subscription->actif ? 'activé' : 'désactivé';
        return back()->with('success', 'Abonnement ' . $status . '.');
    }

    public function destroySubscription(Subscription $subscription)
    {
        if ($subscription->user_id !== auth()->id()) {
            abort(403);
        }

        $subscription->delete();
        return back()->with('success', 'Abonnement supprimé.');
    }
}
