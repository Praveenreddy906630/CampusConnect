<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Carbon\Carbon;

class CheckRegistrationPeriod
{
    public function handle(Request $request, Closure $next)
    {
        // Try to load settings
        $settings = Setting::first();

        // If no settings configured, allow access (so admin can configure them)
        if (! $settings) {
            return $next($request);
        }

        $today = Carbon::today();
        $start = Carbon::parse($settings->registration_start);
        $end   = Carbon::parse($settings->registration_end);

        // If today is before start OR after end -> show "registration closed" page
        if ($today->lt($start) || $today->gt($end)) {
            // Pass the $settings object to the view to avoid "Undefined variable"
            return response()->view('registration_closed', ['settings' => $settings]);
        }

        return $next($request);
    }
}
