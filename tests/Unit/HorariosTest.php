<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use App\Models\Horario;
use Tests\TestCase;

class HorariosTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public $auth;

    public function testHorarios()
    {
        $this->auth = new Horario();
        $request = [
        'data' => '2023-11-25',
        'idFuncionario' => '5'
        ,'idFiltro' => '0'
        ,'idTratamento' => '5'];
    
        $horarios = $this->auth->horarios((object) $request);

        $this->assertIsArray($horarios,'O sistema esta pegando os horarios disponivel');
    }
}