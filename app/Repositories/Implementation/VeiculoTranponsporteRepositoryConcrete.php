<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\VeiculoTransporteRepositoryInterface;

class VeiculoTranponsporteRepositoryConcrete extends Repository implements VeiculoTransporteRepositoryInterface
{
    
    protected function getTypeObject() {
        return '\App\Entities\VeiculoTransporte';
    }
}
