<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllowedIp;

class SystemDashboard extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        return view('system.index');
    }

    public function allowed_ips(Request $request)
    {
        $allowed = $request->validate([
            'ips.*.ip' => 'required|ip',
            'ips.*.notes' => 'nullable|string|max:255',
            'ips.*.expires_at' => 'nullable|date',
        ]);

        AllowedIp::truncate();

        foreach ($allowed['ips'] as $ipData) {
            AllowedIp::create($ipData);
        }

        return redirect()->route('dashboard.system')->with('message', 'Allowed IPs updated successfully.');
    }
}
