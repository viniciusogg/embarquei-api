<?php

namespace App\Services;

use App\Repositories\Abstraction\CheckinRepositoryInterface;

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

    }

    protected function getRepository()
    {
        return $this->checkinRepository;
    }
}