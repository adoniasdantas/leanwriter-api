<?php

namespace App\Http\Middleware;

use App\Comentario;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserCurtiuComentario
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
        $comentario = Comentario::findOrFail($request->route('Comentario'));
        $userId = Auth::guard('api')->user()->id;

        if($comentario->usersCurtiram->contains($userId)) {
            return response()->json(["mensagem" => "Você já curtiu este Comentário"], 403);
        }

        return $next($request);
    }
}
