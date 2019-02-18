<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CidadeService;

class CidadeController extends Controller
{
    private $cidadeService;
    
    public function __construct(CidadeService $cidadeService) 
    {
        $this->cidadeService = $cidadeService;
    }

    public function showByNome($nome)
    {
        $cidade = $this->cidadeService->findByNome($nome);

        if ($cidade)
        {
            return response()->json($cidade->toArray(), 200);
        }
        return response()->json(['response' => 'Cidade não encontrada'], 400);
    }
    
    public function buscarCidadesComRotas()
    {
        $cidades = $this->cidadeService->buscarCidadesComRotas();
        
        if (empty($cidades))
        {
            return response()->json('', 204);
        }
        return response()->json($cidades, 200);
    }

    protected function getService()
    {
        return $this->cidadeService;
    }

    protected function getMensagemErro()
    {
        return 'Cidade não encontrada';
    }


}
