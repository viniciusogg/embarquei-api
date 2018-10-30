<?php

namespace App\Repositories\Abstraction;

interface TrajetoRepositoryInterface 
{

    public function getTrajetosByCidadeInstituicaoRota($cidade, $instituicaoEnsino);
}
