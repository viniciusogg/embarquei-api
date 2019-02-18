<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EstudanteService;

class EstudanteController extends Controller
{
    private $estudanteService;
    
    public function __construct(EstudanteService $estudanteService) 
    {
        $this->estudanteService = $estudanteService;
    }

    public function filtrarPorCidade($cidadeId)
    {
        $estudantes = $this->estudanteService->findByCidade($cidadeId);
        
        if (empty($estudantes))
        {
            return response()->json('', 204);
        }
        return response()->json($estudantes, 200);  
    }
    
    public function alterarStatus(Request $request, $id)
    {
        $estudanteAtualizado = $this->estudanteService->alterarStatus($id, $request->all());
        
        return response()->json($estudanteAtualizado->toArray(), 200);
    }

    protected function getService()
    {
        return $this->estudanteService;
    }

    protected function getMensagemErro()
    {
        return 'Estudante não encontrado';
    }


}
