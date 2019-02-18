<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CheckinService;

class CheckinController extends Controller
{
    private $checkinService;

    public function __construct(CheckinService $checkinService)
    {
        $this->checkinService = $checkinService;
    }

    public function buscarPorEstudante($id)
    {
        $checkin = $this->checkinService->getCheckinByIdEstudante($id);

        if ($checkin)
        {
            return response()->json(array(
                'id' => $checkin->getId(),
                'status' => $checkin->getStatus(),
                'dataUltimaAtualizacao' => $checkin->getDataUltimaAtualizacao()->format('d/m/Y H:i'),
                'estudanteId' => $checkin->getEstudante()->getId(),
                'listaPresencaId' => $checkin->getListaPresenca()->getId()
            ), 200);
        }
        return response()->json(['response' => 'Checkin não encontrado'], 400);
    }

    protected function getService()
    {
        return $this->checkinService;
    }

    protected function getMensagemErro()
    {
        return 'Checkin não encontrado';
    }

}
