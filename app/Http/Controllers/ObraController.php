<?php

namespace App\Http\Controllers;

use App\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class obraController extends Controller
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
    public function index()
    {
        return response()->json(['obras' => Obra::with('autor')->get()->jsonSerialize()]);
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
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        $obra = Obra::create([
            'titulo' => $request->get('titulo'),
            'descricao' => $request->get('descricao'),
            'user_id' => $user->id,
        ]);

        return response()->json(['obra' =>$obra], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($obraId)
    {
        $obra = Obra::with('autor')->findOrFail($obraId);
        return response()->json(['obra' => $obra->jsonSerialize()]);
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
    public function update(Request $request, $id)
    {
        $obra = Obra::findOrFail($id);

        $obra->update([
            'titulo' => $request->get('titulo'),
            'descricao' => $request->get('descricao'),
        ]);

        return response()->json(['obra' =>$obra], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obra = Obra::find($id);

        $obra->delete();

        return 204;
    }
}
