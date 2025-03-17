<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class FlashNotificationMiddleware extends Middleware
{
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'notification' => $request->session()->get('notification'),
        ]);
    }
}
