<?php

namespace App\Repositories\Abstraction;

interface InstituicaoEnsinoRepositoryInterface 
{
    public function getByNome($nome);

    public function associarComMotorista($dadosMotorista, $nomesInstituicoes);

    public function associarComCidade($instituicaoEnsino, $nomeCidade);

}
