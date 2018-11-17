<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\HorarioTrajetoRepositoryInterface;

class HorarioTrajetoRepositoryConcrete  extends Repository implements HorarioTrajetoRepositoryInterface 
{

    protected function getTypeObject() 
    {
        return '\App\Entities\HorarioTrajeto';
    }
}
