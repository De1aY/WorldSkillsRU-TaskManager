<?php

namespace App\Http\Controllers\Models;

use App\Process;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProcessController extends Controller
{
    public function getProcesses()
    {
        $processes = Process::all();
        return response()->json([
            "status" => "success",
            "code" => 200,
            "data" => $processes
        ]);
    }
}
