<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\TrajetoRepositoryInterface;

class TrajetoRepositoryConcrete extends Repository implements TrajetoRepositoryInterface
{

    protected function getTypeObject() 
    {
        return '\App\Entities\Trajeto';
    }
}
