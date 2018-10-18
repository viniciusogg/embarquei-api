<?php

namespace App\Repositories\Abstraction;

interface UsuarioRepositoryInterface
{
    public function getByNumeroCelular($numeroCelular);
}
