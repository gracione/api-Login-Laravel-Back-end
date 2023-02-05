<?php

namespace Tests\Unit;

use App\Models\Tratamentos;
use Tests\TestCase;

class TratamentosTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public $tratamentos;

    public function test_tratamentos()
    {        
        $this->tratamentos = new Tratamentos();
        $this->tratamentos->listar();
        $listar = $this->tratamentos->listar();

        $this->assertIsArray($listar, 'O sistema está listando os tratamentos corretamente');
    }
}
