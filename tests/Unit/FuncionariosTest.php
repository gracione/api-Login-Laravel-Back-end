<?php

namespace Tests\Unit;

use App\Http\Controllers\FuncionariosController;
use Tests\TestCase;

class FuncionariosTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public $funcionarios;

    public function test_funcionario()
    {
        $this->funcionarios = new FuncionariosController();
        $listar = $this->funcionarios->listar();

        $this->assertIsArray($listar);
    }
}
//./vendor/bin/phpunit
