<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Repositories\TaskRepository;
use Exception;

class TasksController extends Controller{

    private $taskRepository;

    /**
     * @param  App\Repositories\TaskRepository  $taskRepository
     */
    public function __construct( TaskRepository $taskRepository){
        $this->taskRepository = $taskRepository;
    }

    /**
     * Returns all database jobs
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        if (!$request->ajax()) return redirect('/');
        try {
            $task = $this->taskRepository->all();
            return  response()->json($task, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

    }

    /**
     * Returns the registered task
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){

        if (!$request->ajax()) return redirect('/');
        try {
            $task = $this->taskRepository->save($request);
            return response()->json($task, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){

        if (!$request->ajax()) return redirect('/');
        try {
            $task = $this->taskRepository->update($request);
            if ($task) {
                return response()->json($task, 200);
            }
            return response()->json('Not found', 404);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Delete a task according to the id received
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){

        if (!$request->ajax()) return redirect('/');
        try {
            $task = $this->taskRepository->delete($id);
            if ($task) {
                return response()->json($task, 200);
            }
            return response()->json('Not found', 404);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Returns the task to which the status has been modified
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id){
        if (!$request->ajax()) return redirect('/');
        try {
            $task = $this->taskRepository->updateStatus($id);
            if ($task) {
                return response()->json($task, 200);
            }
            return response()->json('Not found', 404);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}