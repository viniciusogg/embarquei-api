<?php

namespace App\Repositories\Abstraction;

interface TrajetoRepositoryInterface 
{
    public function cadastrar($trajeto);

    public function atualizar($trajeto);

    public function atualizarStatus($trajeto);

    public function getTrajetosByCidadeInstituicaoRota($cidade, $instituicaoEnsino);
}
