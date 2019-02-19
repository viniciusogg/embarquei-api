<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VeiculoTransporteService;

class VeiculoTransporteController extends Controller
{
    private $veiculoTransporteService;
    
    public function __construct(VeiculoTransporteService $veiculoTransporteService) 
    {
        $this->veiculoTransporteService = $veiculoTransporteService;
    }

    public function filtrarPorCidade($cidadeId)
    {
        $veiculos = $this->veiculoTransporteService->findByCidade($cidadeId);

        if (empty($veiculos))
        {
            return response()->json('', 204);
        }
        return response()->json($veiculos, 200);
    }

    public function filtrarPorInstituicaoCidade($instituicaoId, $cidadeId)
    {
        $veiculo = $this->veiculoTransporteService->findByInstituicaoCidade($instituicaoId, $cidadeId);

        return response()->json($veiculo, 200);
    }

    protected function getService()
    {
        return $this->veiculoTransporteService;
    }

    protected function getMensagemErro()
    {
        return 'Veiculo de transporte não encontrado';
    }


}
