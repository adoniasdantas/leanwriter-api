<?php

namespace App\Http\Controllers;

use App\Obra;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class obraController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('userCurtiu')->only(['like']);
        $this->middleware('userDescurtiu')->only(['dislike']);
    }

    public function rules() {
        return [
            'titulo' => 'required',
            'descricao' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
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

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return response()->json(["mensagem" => $validator->errors()], 422);
        }

        $obra = Obra::create([
            'titulo' => $request->get('titulo'),
            'descricao' => $request->get('descricao'),
            'user_id' => $user->id,
        ]);

        return response()->json([
            'obra' => ["titulo" => $obra->titulo, "descricao" => $obra->descricao, "user_id" => $user->id],
            "mensagem" => "Obra criada com sucesso!"], 201);
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

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return response()->json(["mensagem" => $validator->errors()], 422);
        }

        $obra->update([
            'titulo' => $request->get('titulo'),
            'descricao' => $request->get('descricao'),
        ]);

        return response()->json([
            'obra' => ["titulo" => $obra->titulo, "descricao" => $obra->descricao, "user_id" => $obra->user_id],
            "mensagem" => "Obra editada com sucesso!"], 200);

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

        return response()->json(["mensagem" => "Obra excluída com sucesso!"], 200);
    }

    public function like(Request $request, $id)
    {
        $user = Auth::guard('api')->user();

        $obra = Obra::findOrFail($id);

        $obra->usersCurtiram()->sync($user->id);

        $obra->save();

        return response()->json(["mensagem" => "Sua curtida foi contabilizada com sucesso!"], 200);

    }

    public function dislike($id)
    {
        $user = Auth::guard('api')->user();

        $obra = Obra::findOrFail($id);

        $obra->usersDescurtiram()->sync($user->id);

        $obra->save();

        return response()->json(["mensagem" => "Sua critica foi contabilizada com sucesso!"], 200);
    }
}
