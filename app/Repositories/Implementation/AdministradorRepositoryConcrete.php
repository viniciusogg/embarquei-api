<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\AdministradorRepositoryInterface;
use App\Repositories\Implementation\UsuarioRepositoryConcrete;

class AdministradorRepositoryConcrete extends UsuarioRepositoryConcrete implements AdministradorRepositoryInterface
{

    protected function getTypeObject() 
    {
        return '\App\Entities\Administrador';
    }
}
