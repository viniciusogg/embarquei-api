<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\HorarioSemanalEstudanteRepositoryInterface;

class HorarioSemanalEstudanteRepositoryConcrete extends Repository implements HorarioSemanalEstudanteRepositoryInterface
{

    protected function getTypeObject() 
    {
        return '\App\Entities\HorarioSemanalEstudante';
    }
}
