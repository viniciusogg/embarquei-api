<?php

namespace App\Repositories\Abstraction;

interface CidadeRepositoryInterface 
{
    public function getByNome($nome);
    
    public function buscarCidadesComRotas();
}
