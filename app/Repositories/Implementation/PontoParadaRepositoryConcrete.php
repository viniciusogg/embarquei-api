<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\PontoParadaRepositoryInterface;

class PontoParadaRepositoryConcrete extends Repository implements PontoParadaRepositoryInterface
{

    protected function getTypeObject() 
    {
        return '\App\Entities\PontoParada';
    }
}
