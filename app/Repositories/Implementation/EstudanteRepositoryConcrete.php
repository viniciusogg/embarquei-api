<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\EstudanteRepositoryInterface;
use App\Repositories\Abstraction\Repository;

class EstudanteRepositoryConcrete extends Repository implements EstudanteRepositoryInterface
{

     protected function getTypeObject()
    {
        return '\App\Entities\Estudante';
    }
}
