<?php

namespace App\Http\Middleware;

use App\Capitulo;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserDescurtiuCapitulo
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
        $capitulo = Capitulo::findOrFail($request->route('Capitulo'));
        $userId = Auth::guard('api')->user()->id;

        if($capitulo->usersDescurtiram->contains($userId)) {
            return response()->json(["mensagem" => "Você já descurtiu este Capítulo"], 403);
        }

        return $next($request);
    }
}
