<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\MotoristaRepositoryInterface;
use Exception;

class MotoristaRepositoryConcrete extends Repository implements MotoristaRepositoryInterface
{
    
    protected function getTypeObject() 
    {
        return '\App\Entities\Motorista';
    }
    
}
