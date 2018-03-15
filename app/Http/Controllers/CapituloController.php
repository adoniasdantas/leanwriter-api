<?php

namespace App\Http\Controllers;

use App\Capitulo;
use App\Obra;
use Illuminate\Http\Request;

class CapituloController extends Controller
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
        $obra = Obra::with("capitulos")->findOrFail($obra_id);

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
        $capitulo = Capitulo::create([
            'titulo' => $request->get('titulo'),
            'texto' => $request->get('texto'),
            'obra_id' => $obra->id,
        ]);

        return response()->json(["capitulo" => $capitulo, "obra" => $obra, "mensagem" => "Capítulo criado com sucesso!"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($obraId, $capituloId)
    {
        $obra = Obra::findOrFail($obraId);
        $capitulo = Capitulo::with('feedbacks')->findOrFail($capituloId);
        return response()->json(["capitulo" => $capitulo, "obra" => $obra]);
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
    public function update(Request $request, Obra $obra, Capitulo $capitulo)
    {
        $capitulo->update([
            'titulo' => $request->get('titulo'),
            'texto' => $request->get('texto'),
        ]);

        return response()->json(["capitulo" => $capitulo, "obra" => $obra, "mensagem" => "Capítulo editado com sucesso!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Obra $obra, Capitulo $capitulo)
    {
        $capitulo->delete();

        return response()->json(["mensagem" => "Capítulo excluído com sucesso!"], 200);
    }
}
