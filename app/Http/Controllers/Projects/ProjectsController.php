<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectsResource;
use App\Models\Projects;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $projects = Projects::query()
            ->filterByQueryString()
            ->searchByQueryString()
            ->orderBy('created_at', 'desc')
            ->paginate(perPage: $perPage)->appends(request()->query());

        if ($request->wantsJson()) {
            return response()->json(ProjectsResource::collection($projects));
        }

        return Inertia::render('Projects/Index', [
            'projects' => ProjectsResource::collection($projects),
        ]);

    }

    public function create() {}

    public function store(Request $request) {}

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
