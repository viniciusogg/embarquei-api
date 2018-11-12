<?php

namespace App\Repositories\Abstraction;

interface AdministradorRepositoryInterface 
{
    public function associarComEndereco($administrador, $endereco);
    
    public function getByNumeroCelular($numeroCelular);
}
