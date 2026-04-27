<?php

namespace App\Http\Controllers;

use App\Models\NotificationApp;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
   public function index()
{
    // Marque toutes les notifications comme lues
    // dès que l'utilisateur visite la page
    \App\Models\NotificationApp::where('user_id', auth()->id())
                               ->whereNull('lue_at')
                               ->update(['lue_at' => now()]);

    $notifications = \App\Models\NotificationApp::where('user_id', auth()->id())
                                                ->latest()
                                                ->paginate(20);

    return view('notifications', compact('notifications'));
}

    public function lire(NotificationApp $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }
        $notification->marquerLue();

        return redirect()->back();
    }

    public function lireTout()
    {
        NotificationApp::where('user_id', auth()->id())
                       ->whereNull('lue_at')
                       ->update(['lue_at' => now()]);

        return redirect()->back()
                         ->with('success', 'Toutes les notifications marquées comme lues.');
    }
}