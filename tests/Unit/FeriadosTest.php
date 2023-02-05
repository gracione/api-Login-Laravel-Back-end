<?php

namespace Tests\Unit;

use App\Models\Feriado;
use Tests\TestCase;

class FeriadosTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public $feriados;

    public function test_feriados()
    {        
        $this->feriados = new Feriado();
        $this->feriados->listar();
        $listar = $this->feriados->listar();

        $this->assertIsArray($listar, 'O sistema está listando os feriados corretamente');
    }
}
