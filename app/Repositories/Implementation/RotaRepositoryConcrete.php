<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\RotaRepositoryInterface;

class RotaRepositoryConcrete extends Repository implements RotaRepositoryInterface
{

    protected function getTypeObject() 
    {
        return '\App\Entities\Rota';
    }
}
