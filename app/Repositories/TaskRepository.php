<?php

namespace App\Repositories;
use App\Models\Tasks;
use Illuminate\Support\Carbon;

class TaskRepository {

    private $model;

    public function __construct(){
        $this->model = new Tasks;
    }

    /**
     * Queries all tasks and returns them sorted in descending order
     *
     * @return \App\Models\Tasks
     */
    public function all(){
        return $this->model::orderBy('created_at', 'desc')->get();
    }

    /**
     * Records the task received by the request
     *
     * @param  Object $request
     * @return \App\Models\Tasks
     */
    public function save($request){

        $task = $this->model::Create([
            'name_of_the_task' => $request->name_of_the_task,
            'created_at' => Carbon::now(),
            'status' => 0,
        ]);
        $task-> save();
        return $task;
    }

    /**
     * Updates the task according to the received id
     *
     * @param  Object $request
     * @return \App\Models\Tasks
     */
    public function update($request){

        $task = $this->model::find($request->id);
        if ($task) {
            $task->name_of_the_task = $request->name_of_the_task;
            $task->updated_at = Carbon::now();
            $task->save();
            return response()->json($task, 200);
        }
        return $task;
    }

    /**
     * Delete the task according to the id received
     *
     * @param  int  $id
     * @return \App\Models\Tasks
     */
    public function delete($id){

        $task = $this->model::find($id);
        if ($task) {
            $task->delete();
            return response()->json($task, 200);
        }

        return $task;
    }

    /**
     * Updates the task status according to the task id.
     *
     * @param  int  $id
     * @return \App\Models\Tasks
     */
    public function updateStatus($id){

        $task = $this->model::find($id);
        if ($task) {
            $task->status = !$task->status;
            $task->updated_at = Carbon::now();
            $task->save();
            return response()->json($task, 200);
        }
        return $task;
    }
}