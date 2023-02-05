<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Funcionarios;
use App\Models\Profissao;
use App\Models\Tratamentos;
use Tests\TestCase;

class HorariosTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public $horarios;
    public $funcionarios;
    public $tratamentos;
    public $profissao;

    public function testHorarios()
    {
        $this->funcionarios = new Funcionarios();
        $this->tratamentos = new Tratamentos();
        $this->profissao = new Profissao();
        $listar = $this->funcionarios->listar();
        $usuario = array_pop($listar);
        $listar = $this->profissao->listarByIdFuncionario($usuario);
        $profissao = array_pop($listar);
        $listar = $this->tratamentos->listarByIdProfissao($profissao->id);
        $tratamento = array_pop($listar);
        $listar = $this->funcionarios->listarByIdUsuario($usuario);
        $funcionario = array_pop($listar);

        $this->horarios = new Horario();
        $request = [
        'data' => '2023-11-25',
        'idFuncionario' => $funcionario->id
        ,'idFiltro' => '0'
        ,'idTratamento' => $tratamento->id];
    
        $horarios = $this->horarios->horarios((object) $request);
        $this->assertIsArray($horarios,'O sistema esta pegando os horarios disponivel');

        $horarios = $this->horarios->verificarHorarioModoTradicional($request);
        $this->isTrue($horarios,'O sistema verificando si o horario esta diponivel no modo tradicional');

    }

}