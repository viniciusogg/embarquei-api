<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\CheckinRepositoryInterface;
use App\Repositories\Abstraction\Repository;

class CheckinRepositoryConcrete extends Repository implements CheckinRepositoryInterface
{
    public function getCheckiByIdEstudante($id)
    {

    }

    protected function getTypeObject()
    {
        return '\App\Entities\Checkin';
    }
}