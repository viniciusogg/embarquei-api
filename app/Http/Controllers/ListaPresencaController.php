<?php

namespace App\Http\Controllers;

use App\Services\ListaPresencaService;
use Illuminate\Http\Request;

class ListaPresencaController extends Controller
{
    private $listaPresencaService;

    public function __construct(ListaPresencaService $listaPresencaService)
    {
        $this->listaPresencaService = $listaPresencaService;
    }

    public function filtrarPorInstituicaoMotorista($idMotorista)
    {
        $listasPresenca = $this->listaPresencaService->filtrarPorInstituicaoMotorista($idMotorista);

        if (empty($listasPresenca))
        {
            return response()->json('', 204);
        }
        return response()->json($listasPresenca, 200);
    }

    public function filtrarPorInstituicaoRota($idInstituicao)
    {
        $listasPresenca = $this->listaPresencaService->filtrarPorInstituicaoRota($idInstituicao);

        if (empty($listasPresenca))
        {
            return response()->json('', 204);
        }
        return response()->json($listasPresenca, 200);
    }

    protected function getService()
    {
        return $this->listaPresencaService;
    }

    protected function getMensagemErro()
    {
        return 'Lista de presença não encontrada';
    }


}
