<?php

namespace App\Http\Middleware;

use App\Feedback;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserDescurtiuFeedback
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
        $feedback = Feedback::findOrFail($request->route('Feedback'));
        $userId = Auth::guard('api')->user()->id;

        if($feedback->usersDescurtiram->contains($userId)) {
            return response()->json(["mensagem" => ["erro" => ["Você já curtiu este Feedback"]]], 403);
        }
        return $next($request);
    }
}
