<?php

namespace App\Http\Controllers\Clock;

use App\Http\Controllers\Controller;
use App\Http\Resources\TimerResource;
use App\Models\Clients;
use App\Models\Projects;
use App\Models\Timer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimerController extends Controller
{
    public function index()
    {
        $timer = TimerResource::collection(
            Timer::with(['projects', 'clients'])
                ->paginate()
        );

        return Inertia::render('timer/Index', [
            'timer' => $timer,
            'fields' => [
                'clients' => Clients::all(),
                'projects' => Projects::all(),
            ],
        ]);
    }

    public function create() {}

    public function store(Request $request) {}

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
