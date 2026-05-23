<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request): JsonResponse|\Illuminate\View\View
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['data' => $settings]);
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable',
            'settings.*.group' => 'nullable|string',
            'settings.*.type' => 'nullable|in:string,boolean,integer,float,json',
        ]);

        foreach ($data['settings'] as $item) {
            Setting::set(
                $item['key'],
                $item['value'] ?? '',
                $item['group'] ?? 'general',
                $item['type'] ?? 'string'
            );
        }

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Settings updated successfully.']);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
