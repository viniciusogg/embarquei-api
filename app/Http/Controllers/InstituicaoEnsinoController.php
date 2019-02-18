<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InstituicaoEnsinoService;

class InstituicaoEnsinoController extends Controller
{
    private $instituicaoEnsinoService;
    
    public function __construct(InstituicaoEnsinoService $instituicaoEnsinoService) 
    {
        $this->instituicaoEnsinoService = $instituicaoEnsinoService;
    }

    public function buscarInstituicoesSemMotorista($cidadeId)
    {
        $instituicoesEnsino = $this->instituicaoEnsinoService->buscarInstituicoesSemMotorista($cidadeId);

        if (empty($instituicoesEnsino))
        {
            return response()->json('', 204);
        }
        return response()->json($instituicoesEnsino, 200);
    }

    public function buscarInstituicoesSemVeiculo($cidadeId)
    {
        $instituicoesEnsino = $this->instituicaoEnsinoService->buscarInstituicoesSemVeiculo($cidadeId);

        if (empty($instituicoesEnsino))
        {
            return response()->json('', 204);
        }
        return response()->json($instituicoesEnsino, 200);
    }

    public function buscarInstituicoesComRota($cidadeId)
    {
        $instituicoesEnsino = $this->instituicaoEnsinoService->buscarInstituicoesComRota($cidadeId);

        if (empty($instituicoesEnsino))
        {
            return response()->json('', 204);
        }
        return response()->json($instituicoesEnsino, 200);
    }

    protected function getService()
    {
        return $this->instituicaoEnsinoService;
    }

    protected function getMensagemErro()
    {
        return 'Instituição de ensino não encontrada';
    }

}
