<?php

namespace App\Http\Controllers\Projects;

use App\Enums\DefaultWindowSize;
use App\Enums\Status as StatusEnum;
use App\Enums\WindowName;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectsRequest;
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
            Projects::query()
                ->filterByQueryString()
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

    public function store(ProjectsRequest $request)
    {

        Projects::create([
            'user_id' => auth()->id(),
            ...$request->validated(),
        ]);

        $request->session()->flash('notification', [
            'success' => [
                'title' => 'Project Created',
                'description' => 'Project has been created successfully.',
            ],
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Project Created',
                'description' => 'Project has been successfully created.',
            ], \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
        }

        return $this->index(new Request);
    }

    public function show(Projects $project)
    {
        return Inertia::render('projects/Show', [
            'project' => ProjectsResource::make($project->load('clients')),
        ]);
    }

    public function edit(Projects $project) {}

    public function update(Request $request, $id) {}

    public function destroy(Projects $project, Request $request)
    {
        $project->delete();

        $request->session()->flash('notification', [
            'success' => [
                'title' => 'Project Deleted',
                'description' => 'Project has been deleted successfully.',
            ],
        ]);

        return $this->index(new Request);
    }

    public function tableFilterStatus()
    {
        return response()->json([
            'status' => StatusEnum::cases(),
        ]);

    }
}
