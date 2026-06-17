<?php

namespace App\Http\Controllers;

use App\Policies\SettingsPolicy;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private SettingsPolicy $policy;

    public function __construct()
    {
        $this->policy = new SettingsPolicy();
    }

    public function index()
    {
        if (!$this->policy->viewAny(request()->user())) {
            abort(403, 'No tienes permiso para acceder a la configuración.');
        }
        return view('pages.settings');
    }

    public function pagination(Request $request)
    {
        if (!$this->policy->create(request()->user())) {
            abort(403, 'No tienes permiso para crear configuración.');
        }

        $validated = $request->validate([
            'per_page' => ['required', 'integer', 'min:1'],
        ]);

        set_setting('pagination_per_page', (int) $validated['per_page']);

        return redirect()->route('settings.index')->with('status', 'Configuración guardada correctamente.');
    }
}
