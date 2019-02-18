<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PontoParadaService;

class PontoParadaController extends Controller
{
    private $pontoParadaService;
    
    public function __construct(PontoParadaService $pontoParadaService) 
    {
        $this->pontoParadaService = $pontoParadaService;
    }
    
    public function buscarPontosParadaByCidadeInstituicaoRota($cidade, $instituicaoEnsino, $rota)
    {  
        $pontosParada = $this->pontoParadaService->
                getPontosParadaByCidadeInstituicaoRota($cidade, $instituicaoEnsino, $rota);
        
        return response()->json($pontosParada, 200);
    }

    protected function getService()
    {
        return $this->pontoParadaService;
    }

    protected function getMensagemErro()
    {
        return 'Ponto de parada não encontrado';
    }

}
