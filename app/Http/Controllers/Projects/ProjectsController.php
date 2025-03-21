<?php

namespace App\Http\Controllers\Projects;

use App\Enums\DefaultWindowSize;
use App\Enums\Status as StatusEnum;
use App\Enums\WindowName;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectsResource;
use App\Models\Clients;
use App\Models\Projects;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Native\Laravel\Facades\Window;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $projects = ProjectsResource::collection(
            Projects::filterByQueryString()
                ->searchByQueryString()
                ->with('clients')
                ->orderBy('created_at', 'desc')
                ->paginate(perPage: $perPage)->appends(request()->query()));

        if ($request->wantsJson()) {
            return $projects;
        }

        if (! app()->runningInConsole() && ! app()->runningUnitTests()) {
            Window::resize(DefaultWindowSize::DEFAULT_MIN_WIDTH->getSize() + 300, DefaultWindowSize::DEFAULT_MIN_HEIGHT->getSize(), WindowName::MAIN->getId());
        }

        return Inertia::render('projects/Index', [
            'projects' => $projects,
        ]);

    }

    public function create()
    {

        if (! app()->runningInConsole() && ! app()->runningUnitTests()) {
            Window::resize(DefaultWindowSize::DEFAULT_MIN_WIDTH->getSize() + 150, DefaultWindowSize::DEFAULT_MIN_HEIGHT->getSize(), WindowName::MAIN->getId());
        }

        return Inertia::render('projects/Create', [
            'fields' => [
                'clients' => Clients::all(),
                'status' => StatusEnum::cases(),
            ],
        ]);
    }

    public function store(Request $request) {}

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}

    public function tableFilterStatus()
    {
        return response()->json([
            'status' => StatusEnum::cases(),
        ]);

    }
}
