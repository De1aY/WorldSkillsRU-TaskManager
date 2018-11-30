<?php

namespace App\Http\Controllers\Models;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function getTasks()
    {
        $tasks = Task::all();
        return response()->json([
            "status" => "success",
            "code" => 200,
            "data" => $tasks
        ]);
    }

    public function addTask(Request $request)
    {
        if($this->validateAddTaskRequestData($request)) {
            return response()->json([
                'status' => 'error',
                'code' => 501,
                'message' => 'Неверный формат данных'
            ], 200);
        }
        $task = new Task;
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $due_date = date_create($request->input('due_date'));
        $task->due_date = date_format($due_date, 'Y-m-d H:i:s');
        if ($task->due_date == false) {
            return response()->json([
                'status' => 'error',
                'code' => 501,
                'message' => 'Неверный формат данных'
            ], 200);
        }
        $task->save();
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'id' => $task->id,
        ], 200);
    }

    private function validateAddTaskRequestData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:64',
            'description' => 'required|min:1|max:255',
            'due_date' => 'required|date'
        ]);
        return $validator->fails();
    }

}
