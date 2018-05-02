<?php

namespace App\Http\Controllers;

use App\Obra;
use App\Capitulo;
use App\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function rules() {
        return [
            'texto' => 'required',
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
    public function index($obra_id, $capitulo_id)
    {
        $capitulo = Capitulo::with("feedbacks.autor")->findOrFail($capitulo_id);

        return response()->json(["capitulo" => $capitulo]);
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
    public function store(Request $request, Obra $obra, Capitulo $capitulo)
    {
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return response()->json(["mensagem" => $validator->errors()], 422);
        }

        $feedback = Feedback::create([
            'texto' => $request->get('texto'),
            'user_id' => $user->id,
            'capitulo_id' => $capitulo->id,
        ]);

        return response()->json(["capitulo" => $capitulo, "feedback" => $feedback, "mensagem" => "Feedback criado com sucesso!"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Obra $obra, Capitulo $capitulo, Feedback $feedback)
    {
        return response()->json([
            "obra" => $obra,
            "capitulo" => $capitulo,
            "feedback" => $feedback,
            "autor" => $feedback->autor,
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
    public function update(Request $request, Obra $obra, Capitulo $capitulo, Feedback $feedback)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return response()->json(["mensagem" => $validator->errors()], 422);
        }

        $feedback->update([
            'texto' => $request->get('texto'),
        ]);

        return response()->json([
            "obra" => $obra,
            "capitulo" => $capitulo,
            "feedback" => $feedback,
            "mensagem" => "Feedback editado com sucesso!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Obra $obra, Capitulo $capitulo, Feedback $feedback)
    {
        $feedback->delete();

        return response()->json(["mensagem" => "Feedback excluido com sucesso!"], 200);
    }

    public function like($obraId, $capituloId, $feedbackId)
    {
        $feedback = Feedback::findOrFail($feedbackId);

        $feedback->likes++;

        $feedback->save();

        return response()->json(["mensagem" => "Sua curtida foi contabilizada com sucesso!"]);
    }

    public function dislike($obraId, $capituloId, $feedbackId)
    {
        $feedback = Feedback::findOrFail($feedbackId);

        $feedback->dislikes++;

        $feedback->save();

        return response()->json(["mensagem" => "Sua critica foi contabilizada com sucesso!"]);
    }
}
