<?php

namespace App\Http\Controllers\Projects;

use App\Enums\DefaultWindowSize;
use App\Enums\Status as StatusEnum;
use App\Enums\WindowName;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectsResource;
use App\Models\Projects;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Native\Laravel\Facades\Window;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $projects = Projects::query()
            ->with('clients')
            ->filterByQueryString()
            ->searchByQueryString()
            ->orderBy('created_at', 'desc')
            ->paginate(perPage: $perPage)->appends(request()->query());

        if ($request->wantsJson()) {
            return response()->json(ProjectsResource::collection($projects));
        }

        if (! app()->runningInConsole() && ! app()->runningUnitTests()) {
            Window::resize(DefaultWindowSize::WIDTH->getSize() + 300, DefaultWindowSize::HEIGHT->getSize(), WindowName::MAIN->getId());
        }

        return Inertia::render('projects/Index', [
            'projects' => ProjectsResource::collection($projects),
        ]);

    }

    public function create() {}

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
