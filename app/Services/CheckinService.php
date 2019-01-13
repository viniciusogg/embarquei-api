<?php

namespace App\Services;

use App\Repositories\Abstraction\CheckinRepositoryInterface;
use App\Entities\Checkin;
use Carbon\Carbon;

class CheckinService extends Service
{
    private $checkinRepository;

    public function __construct(CheckinRepositoryInterface $checkinRepository)
    {
        $this->checkinRepository = $checkinRepository;
    }

    public function getCheckinByIdEstudante($id)
    {
        $checkin = $this->checkinRepository->getCheckiByIdEstudante($id);

        return $checkin;
    }

    protected function criarInstancia($dados)
    {
        $checkin = new Checkin();
        $checkin->setDataUltimaAtualizacao(Carbon::now()); //$dados['dataUltimaAtualizacao']
        $checkin->setStatus($dados['status']);
        return $checkin;
    }

    protected function getRepository()
    {
        return $this->checkinRepository;
    }
}