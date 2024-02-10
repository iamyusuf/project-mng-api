<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function projects(): JsonResponse
    {
        $projects = Project::paginate();
        return response()->json($projects);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required'
        ]);

        $project = new Project;
        $project->name = $request->name;
        $project->details = $request->details;
        $project->save();

        return response()->json($project);
    }


    public function update(Project $project, Request $request): JsonResponse
    {
        $request->validate(['name' => 'required']);

        $project->name = $request->name;
        $project->details = $request->details;
        $project->save();

        return response()->json($project);
    }
}
