<?php

namespace Tests\Unit;

use App\Models\Folgas;
use Tests\TestCase;

class FolgasTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public $folgas;

    public function test_folgas()
    {        
        $this->folgas = new Folgas();
        $this->folgas->listar();
        $listar = $this->folgas->listar();

        $this->assertIsArray($listar, 'O sistema está listando as folgas corretamente');
    }
}
