<?php

namespace App\Http\Middleware;

use App\Obra;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserDescurtiuObra
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
        $obra = Obra::findOrFail($request->route('Obra'));
        $userId = Auth::guard('api')->user()->id;

        if($obra->usersDescurtiram->contains($userId)) {
            return response()->json(["mensagem" => ["erro" => ["Você já descurtiu esta Obra"]]], 403);
        }

        return $next($request);
    }
}
