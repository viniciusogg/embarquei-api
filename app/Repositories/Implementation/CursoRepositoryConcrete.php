<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\CursoRepositoryInterface;
use App\Repositories\Abstraction\Repository;

class CursoRepositoryConcrete extends Repository implements CursoRepositoryInterface
{

    protected function getTypeObject() 
    {
        return '\App\Entities\Curso';
    }
}
