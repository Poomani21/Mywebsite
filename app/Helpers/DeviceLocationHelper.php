<?php

namespace App\Helpers;

use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;
use Illuminate\Support\Carbon;
class DeviceLocationHelper
{
    public static function getDeviceLocationData(Request $request): array
    {
        $agent = new Agent();

         //Get real client IP behind proxy
        $ip = $request->header('X-Forwarded-For');

        if ($ip) {
            $ip = explode(',', $ip)[0];
        } else {
            $ip = $request->ip();
        }

        if ($ip === '127.0.0.1' || $ip === '::1') {
            $ip = env('LOCATION_TESTING_IP', '8.8.8.8');
        }

        $position = Location::get($ip);

        return [
            'type' => $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop'),
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
            'ip' => $request->ip(),

            'country' => $position->countryName ?? null,
            'region' => $position->regionName ?? null,
            'city' => $position->cityName ?? null,
            'lat' => $position->latitude ?? null,
            'lon' => $position->longitude ?? null,
            'timezone' => $position->timezone ?? null,

            'time' => new UTCDateTime(Carbon::now()->getTimestamp()*1000),
        ];
    }
}
