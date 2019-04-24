<?php

namespace App\Repositories\Abstraction;

interface TrajetoRepositoryInterface 
{
    public function cadastrar($trajeto);

    public function getTrajetosByCidadeInstituicaoRota($cidade, $instituicaoEnsino);
}
