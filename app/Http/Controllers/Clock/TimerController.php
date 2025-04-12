<?php

namespace App\Http\Controllers\Clock;

use App\Enums\TimerStatusEnums;
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

    public function store(Request $request)
    {
        $request->validate([
            'clients_id' => ['required'],
            'projects_id' => ['required'],
            'duration' => ['nullable'],
            'status' => ['nullable'],
            'timer' => ['required'],
        ]);

        $timer = Timer::create([
            'user_id' => $request->user()->id,
            'clients_id' => $request->client_id,
            'projects_id' => $request->project_id,
            'duration' => $request->duration ?? 0,
            'status' => $request->status ?? TimerStatusEnums::Initiated,
            'timer' => $request->options
        ]);

        return response()->json([
            'id' => $timer->id,
        ]);

    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
