<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ObraTest extends TestCase
{

    public function testCreateObra()
    {

        $user = factory(User::class)->create();

        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        $data = [
            'titulo' => 'Dexter',
            'descricao' => 'A história de um assassino frio e sanguinário'
        ];

        $response = $this->json('POST', '/api/v1/obras', $data, $headers);

        $response->assertStatus(201)
            ->assertJson([
                'obra' => array_merge($data, ["user_id" => $user->id]),
                "mensagem" => "Obra criada com sucesso!"]
            );
    }

    public function testCreateObraSemDescricao()
    {

        $user = factory(User::class)->create();

        $token = $user->generateToken();

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

    public function testCreateObraSemTitulo()
    {

        $user = factory(User::class)->create();

        $token = $user->generateToken();

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
