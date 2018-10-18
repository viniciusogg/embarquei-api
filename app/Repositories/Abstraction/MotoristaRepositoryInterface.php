<?php

namespace App\Repositories\Abstraction;

interface MotoristaRepositoryInterface 
{
    public function getByNumeroCelular($numeroCelular);
    
    public function associarComInstituicao($motorista, $nomesInstituicoes);
}
