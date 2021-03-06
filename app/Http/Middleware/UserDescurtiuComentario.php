<?php

namespace App\Http\Middleware;

use App\Comentario;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserDescurtiuComentario
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
            return response()->json(["mensagem" => ["erro" => ["Você não pode curtir e descurtir o mesmo Comentário"]]], 403);
        }

        if($comentario->usersDescurtiram->contains($userId)) {
            return response()->json(["mensagem" => ["erro" => ["Você já descurtiu este Comentário"]]], 403);
        }

        return $next($request);
    }
}
