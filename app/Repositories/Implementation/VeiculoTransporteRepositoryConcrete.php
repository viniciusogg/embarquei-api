<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\VeiculoTransporteRepositoryInterface;

class VeiculoTransporteRepositoryConcrete extends Repository implements VeiculoTransporteRepositoryInterface
{
    
    protected function getTypeObject() {
        return '\App\Entities\VeiculoTransporte';
    }
}
