<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HorarioTrajetoService;

class HorarioTrajetoController extends Controller
{
    private $horarioTrajetoService;
    
    public function __construct(HorarioTrajetoService $horarioTrajetoService) 
    {
        $this->horarioTrajetoService = $horarioTrajetoService;
    }

    protected function getService()
    {
        return $this->horarioTrajetoService;
    }

    protected function getMensagemErro()
    {
        return 'Horário do trajeto não encontrado';
    }

}
