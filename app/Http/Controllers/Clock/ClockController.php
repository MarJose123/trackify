<?php

namespace App\Http\Controllers\Clock;

use App\Http\Controllers\Controller;
use App\Http\Resources\TimerResource;
use App\Models\Timer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClockController extends Controller
{
    public function index()
    {
        $timer = TimerResource::collection(
            Timer::with(['projects', 'clients'])
                ->paginate()
        );

        return Inertia::render('clock/Index', [
            'timer' => $timer,
        ]);
    }

    public function create() {}

    public function store(Request $request) {}

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
