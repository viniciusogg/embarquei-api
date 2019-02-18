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

    protected function getService()
    {
        return $this->listaPresencaService;
    }

    protected function getMensagemErro()
    {
        return 'Lista de presença não encontrada';
    }


}
