<?php
/**
 * Created by PhpStorm.
 * User: vinicius
 * Date: 03/01/19
 * Time: 17:46
 */

namespace App\Exceptions;

use \Exception;

class ValorEnumInvalidoException extends Exception
{
    public function __construct($enum)
    {
        parent::__construct('Não existe o valor passado no enum ' .  $enum);
    }
}