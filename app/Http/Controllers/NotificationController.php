<?php

namespace App\Http\Controllers;

use App\Models\NotificationApp;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = NotificationApp::where('user_id', auth()->id())
                                        ->latest()
                                        ->paginate(20);

        // Marque les non lues comme vues
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