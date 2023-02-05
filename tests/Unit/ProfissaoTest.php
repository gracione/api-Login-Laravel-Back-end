<?php

namespace Tests\Unit;

use App\Models\Profissao;
use Tests\TestCase;

class ProfissaoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public $profissao;

    public function test_profissao()
    {        
        $this->profissao = new Profissao();
        $this->profissao->listar();
        $listar = $this->profissao->listar();

        $this->assertIsArray($listar, 'O sistema está listando as profissão corretamente');
    }
}
