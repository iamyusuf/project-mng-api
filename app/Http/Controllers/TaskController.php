<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();
        $this->addTaskFilters($query, $request);
        $data = $query->paginate();

        return response()->json($data);
    }

    public function store(TaskRequest $request)
    {
        $task = new Task($request->all());
        $task->save();
        return response()->json($task, Response::HTTP_CREATED);
    }

    public function update(Task $task, Request $request)
    {
        $task->fill($request->all());
        $task->save();

        return response()->json($task, Response::HTTP_OK);
    }

    public function delete(Task $task)
    {
        $id = $task->getKey();
        $task->delete();
        return response()->json(['id' => $id], Response::HTTP_NO_CONTENT);
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    private function addTaskFilters(Builder $query, Request $request)
    {
        $queryableFields = [
            'project_id',
            'epic_id',
            'story_id'
        ];

        foreach ($queryableFields as $field) {
            $query->where($request->has($field), function ($q) use ($request, $field) {
                $q->where($field, $request->input($field));
            });
        }
    }
}
