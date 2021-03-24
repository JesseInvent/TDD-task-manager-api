<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return response()->json(TaskResource::collection(auth()->user()->tasks()->get()->all()), Response::HTTP_OK);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responsedxf
     */
    public function store(TaskRequest $request)
    {

        $task = auth()->user()->tasks()->create(request()->all());
        // $task = Task::create(request()->all());
        return response()->json(new TaskResource($task), Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return response()->json(new TaskResource($task), Response::HTTP_OK);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
       $updatedTask = $task->update(request()->all());
       return response()->json($updatedTask, Response::HTTP_ACCEPTED);
    }


    /**
     * Get User completed Tasks
     */
    public function getUserCompletedTasks()
    {
        $userTasks = auth()->user()->tasks()->get();
        $completedTasks = array_filter($userTasks->all(), function($task) {
           return $task->completed();
       });

       return response()->json($completedTasks, Response::HTTP_OK);
    }


    /**
     * Mark a task as completed
     */
    public function markAsCompleted(Task $task)
    {
        // !! indicates a boolean operation
        if (!$task->completed()) {
            $task->completedTask()->create([
                'user_id' => auth()->user()->id
            ]);
            return response()->json(new TaskResource($task), Response::HTTP_CREATED);
        }

        return response()->json(['Task already marked as completed'], Response::HTTP_UNPROCESSABLE_ENTITY);
      
    }


    /**
     * Mark a task as uncompleted
     */
    public function markAsUnCompleted(Task $task)
    {
       $task->completedTask()->where('task_id', $task->id)->delete();
       return response()->json('success', Response::HTTP_NO_CONTENT);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response('deleted', Response::HTTP_NO_CONTENT);
    }
}
