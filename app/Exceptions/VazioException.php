<?php

namespace App\Exceptions;

use Exception;

class VazioException extends Exception
{
    public function __construct($entidade) 
    {
        parent::__construct('Não existem registros para a entidade ' . $entidade);
    }
}
