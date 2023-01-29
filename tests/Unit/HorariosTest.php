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
    public $horarios;

    public function testHorarios()
    {
        $this->horarios = new Horario();
        $request = [
        'data' => '2023-11-25',
        'idFuncionario' => '5'
        ,'idFiltro' => '0'
        ,'idTratamento' => '5'];
    
        $horarios = $this->horarios->horarios((object) $request);
        $this->assertIsArray($horarios,'O sistema esta pegando os horarios disponivel');
    }

    public function testModoTradicional(){
        $this->horarios = new Horario();
        $request = [
            'data' => '2023-01-28',
            'idFuncionario' => '5'
            ,'idFiltro' => '0'
            ,'idTratamento' => '5'
            ,'modoTradicional' => '19:10'
        ];
    
        $horarios = $this->horarios->verificarHorarioModoTradicional($request);
        $this->isTrue($horarios,'O sistema verificando si o horario esta diponivel no modo tradicional');

    }
}