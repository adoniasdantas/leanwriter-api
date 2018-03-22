<?php

namespace Tests\Unit;

use App\Obra;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateObraTest extends TestCase
{

    public function testUpdateObra()
    {
        $obra = Obra::first();

        $user = User::findOrFail($obra->user_id);

        $token = $user->api_token;

        $headers = ['Authorization' => "Bearer $token"];

        $data = [
            'titulo' => 'Dexter',
            'descricao' => 'A história de um policial que é assassino frio e sanguinário'
        ];

        $uri = "/api/v1/obras/$obra->id";

        echo $uri;

        $response = $this->json('PUT', $uri, $data, $headers);

        $response->assertStatus(200)
            ->assertJson([
                    'obra' => array_merge($data, ["user_id" => $user->id]),
                    "mensagem" => "Obra editada com sucesso!"]
            );
    }

    public function testUpdateObraSemDescricao()
    {
        $obra = Obra::first();

        $user = User::findOrFail($obra->user_id);

        $token = $user->api_token;

        $headers = ['Authorization' => "Bearer $token"];

        $data = [
            'titulo' => 'Dexter',
            'descricao' => ''
        ];

        $response = $this->json('POST', '/api/v1/obras', $data, $headers);

        $response->assertStatus(422)
            ->assertJson([
                "mensagem" => ["descricao" => json_decode('["O campo descricao é obrigatório"]')]
            ]);
    }

    public function testUpdateObraSemTitulo()
    {
        $obra = Obra::first();

        $user = User::findOrFail($obra->user_id);

        $token = $user->api_token;

        $headers = ['Authorization' => "Bearer $token"];

        $data = [
            'titulo' => '',
            'descricao' => 'A história de um assassino frio e sanguinário'
        ];

        $response = $this->json('POST', '/api/v1/obras', $data, $headers);

        $response->assertStatus(422)
            ->assertJson([
                "mensagem" => ["titulo" => json_decode('["O campo titulo é obrigatório"]')]
            ]);
    }

}
