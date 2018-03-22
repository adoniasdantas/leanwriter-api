<?php

namespace Tests\Unit;

use App\Comentario;
use App\Obra;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateComentarioTest extends TestCase
{
    public function testCreateComentario()
    {
        $obra = Obra::first();

        $user = User::first();

        $token = $user->api_token;

        $headers = ['Authorization' => "Bearer $token"];

        $data = [
            'texto' => 'Um comentário interessante',
        ];

        $uri = "/api/v1/obras/$obra->id/comentarios";

        $response = $this->json('POST', $uri, $data, $headers);

        $response->assertStatus(201)
            ->assertJson([
                    'comentario' => array_merge($data, ["user_id" => $user->id]),
                    "mensagem" => "Comentário criado com sucesso!"]
            );
    }

    public function testCreateComentarioSemTexto()
    {
        $comentario = Comentario::first();

        $obra = Obra::findOrFail($comentario->obra_id);

        $user = User::findOrFail($comentario->user_id);

        $token = $user->api_token;

        $headers = ['Authorization' => "Bearer $token"];

        $data = [
            'texto' => '',
        ];

        $uri = "/api/v1/obras/$obra->id/comentarios/$comentario->id";

        $response = $this->json('PUT', $uri, $data, $headers);

        $response->assertStatus(422)
            ->assertJson([
                "mensagem" => ["texto" => json_decode('["O campo texto é obrigatório"]')]
            ]);
    }
}
