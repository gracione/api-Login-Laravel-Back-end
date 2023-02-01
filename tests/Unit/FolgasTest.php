<?php

namespace Tests\Unit;

use App\Http\Controllers\FolgasController;
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
        $this->folgas = new FolgasController();
        $listar = $this->folgas->listar();

        $this->isTrue($listar);
    }
}
//./vendor/bin/phpunit
