<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MotoristaService;

class MotoristaController extends Controller
{
    private $motoristaService;
    
    public function __construct(MotoristaService $motoristaService) 
    {
        $this->motoristaService = $motoristaService;
    }

    public function filtrarPorCidade($cidadeId)
    {
        $motoristas = $this->motoristaService->findByCidade($cidadeId);

        if (empty($motoristas))
        {
            return response()->json('', 204);
        }
        return response()->json($motoristas, 200);
    }

    protected function getService()
    {
        return $this->motoristaService;
    }

    protected function getMensagemErro()
    {
        return 'Motorista não encontrado';
    }

}
