<?php

namespace Tests\Unit;

use App\Http\Controllers\FuncionariosController;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
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
//        $this->assertTrue(true);
    }
}
//./vendor/bin/phpunit
