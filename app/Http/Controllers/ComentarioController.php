<?php

namespace App\Http\Controllers;

use App\Obra;
use App\User;
use App\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($obra_id)
    {
        $obra = Obra::with("comentarios.usuario")->findOrFail($obra_id);

        return response()->json(["obra" => $obra]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Obra $obra)
    {
        $user = Auth::guard('api')->user();
        $comentario = Comentario::create([
            'texto' => $request->get('texto'),
            'obra_id' => $obra->id,
            'user_id' => $user->id,
        ]);

        return response()->json(["comentario" => $comentario, "obra" => $obra, "mensagem" => "Comentário criado com sucesso!"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Obra $obra, Comentario $comentario)
    {

        return response()->json([
            "comentario" => $comentario,
            "obra" => $obra,
            "autor" => User::select('name', 'email')->find($comentario->user_id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Obra $obra, Comentario $comentario)
    {
        $comentario->update([
            'texto' => $request->get('texto'),
        ]);

        return response()->json(["comentario" => $comentario, "obra" => $obra, "mensagem" => "Comentário editado com sucesso!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Obra $obra, Comentario $comentario)
    {
        $comentario->delete();

        return response()->json(["mensagem" => "Comentário excluído com sucesso!"], 200);
    }
}
