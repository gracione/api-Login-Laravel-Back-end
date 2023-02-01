<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use App\Http\Controllers\API\AuthController;
use Tests\TestCase;

class AutenticaoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public $auth;

    public function testAutenticacaoLogin()
    {
        $this->auth = new AuthController();

        $response = $this->postJson('/api/login', ['email' => 'adm@gmail.com', 'password' => '1234']);
        $data = !empty($response->baseResponse->original['token']) ? true : false;

        $this->assertNotTrue($data,'O sistema está validando a autenticação corretamente');

        $response = $this->postJson('/api/login', ['email' => 'adm@gmail.com', 'password' => '123']);
        $data = !empty($response->baseResponse->original['token']) ? true : false;

        $this->assertTrue($data,'O sistema está autenticando corretamente');
    }
}