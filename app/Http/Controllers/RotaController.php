<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RotaService;

class RotaController extends Controller
{
    private $rotaService;
    
    public function __construct(RotaService $rotaService) 
    {
        $this->rotaService = $rotaService;
    }

    public function filtrarPorInstituicaoCidade($instituicaoId, $cidadeId)
    {
        $rota = $this->rotaService->findByInstituicaoCidade($instituicaoId, $cidadeId);

        return response()->json($rota, 200);
    }

    protected function getService()
    {
        return $this->rotaService;
    }

    protected function getMensagemErro()
    {
        return 'Rota não encontrada';
    }

}
