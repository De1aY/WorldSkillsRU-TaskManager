<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class IsAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        switch ($request->method()) {
            case "GET":
                {
                    $sid = $request->cookie('sid');
                    return $this->validate($sid, $request, $next);
                }
            case "POST":
                {
                    $sid = $request->input('sid');
                    return $this->validate($sid, $request, $next);
                }
            case "PUT":
                {
                    $sid = $request->input('sid');
                    return $this->validate($sid, $request, $next);
                }
            default:
                {
                    return response(null, 405);
                }
        }
    }

    private function validate($sid, $request, Closure $next)
    {
        if (!$this->validateSessionData($sid))
        {
            return response()->json([
                'status' => 'error',
                'code' => 402,
                'message' => 'Сессия истекла'
            ], 200);
        }
        try
        {
            $user = User::where('session_id', $sid)->firstOrFail();
        }
        catch (ModelNotFoundException $e)
        {
            return response()->json([
                'status' => 'error',
                'code' => 403,
                'message' => 'Сессия истекла'
            ], 200);
        }
        return $next($request);
    }

    private function validateSessionData($sid) {
        return strlen($sid) == 64;
    }
}
