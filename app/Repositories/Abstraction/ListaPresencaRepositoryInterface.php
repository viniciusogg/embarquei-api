<?php

namespace App\Repositories\Abstraction;

interface ListaPresencaRepositoryInterface
{
    public function filtrarPorInstituicaoMotorista($idMotorista);

    public function filtrarPorInstituicaoRota($idInstituicao);
}
