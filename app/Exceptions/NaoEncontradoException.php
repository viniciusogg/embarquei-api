<?php

namespace App\Exceptions;

use Exception;

class NaoEncontradoException extends Exception
{
    public function __construct() 
    {
        parent::__construct('Nenhum registro foi encontrado para essa busca');
    }
}
