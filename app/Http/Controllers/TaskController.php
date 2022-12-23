<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskMaster;
use App\Http\Requests\CreateTask;
use App\Services\TaskServices;

class TaskController extends Controller {
    public function index() {
        $data = [];
        $data['periods']   = config('constants.periods');
        return view('task', $data);
    }

    /* list data through ajax  */
    public function load(Request $request, TaskServices $taskService) {
        // if ajax request
        if ($request->ajax()) {

            $task = $taskService->loadTasks($request);
            return $task;

        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function create(CreateTask $request, TaskServices $taskService) {
        if ($request->ajax()) {

            $task = $taskService->createTask($request);
            return $task;

        } else {
            return 'No direct access allowed!';
        }
    }

    public function complete(Request $request, TaskServices $taskService) {
        // if ajax request
        if ($request->ajax()) {

            $task = $taskService->completeTasks($request);
            return $task;

        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function pending(Request $request, TaskServices $taskService) {
        // if ajax request
        if ($request->ajax()) {

            $task = $taskService->pendingTasks($request);
            return $task;

        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function delete(Request $request, TaskServices $taskService) {
        // if ajax request
        if ($request->ajax()) {

            $task = $taskService->deleteTasks($request);
            return $task;

        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function truncate() {
        Task::truncate();
        TaskMaster::truncate();
        return true;
    }
}
