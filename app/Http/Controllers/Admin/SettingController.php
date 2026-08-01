<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::first(); // We’ll always use the first record
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'registration_start'   => 'required|date',
                'registration_end'     => 'required|date|after_or_equal:registration_start',
                'max_outdoor_events'   => 'required|integer|min:0',
                'max_indoor_events'    => 'required|integer|min:0',
                'max_cultural_events'  => 'required|integer|min:0',
            ]);

            $settings = Setting::first();
            $settings->update($request->only([
                'registration_start',
                'registration_end',
                'max_outdoor_events',
                'max_indoor_events',
                'max_cultural_events',
            ]));

            return redirect()->route('admin.settings.edit')
                ->with('success', 'Settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
