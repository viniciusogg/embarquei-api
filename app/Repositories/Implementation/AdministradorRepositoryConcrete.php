<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\AdministradorRepositoryInterface;

class AdministradorRepositoryConcrete extends Repository implements AdministradorRepositoryInterface
{

    protected function getTypeObject() 
    {
        return '\App\Entities\Administrador';
    }
}
