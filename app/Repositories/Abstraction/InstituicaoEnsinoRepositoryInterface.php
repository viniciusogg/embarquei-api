<?php

namespace App\Repositories\Abstraction;

interface InstituicaoEnsinoRepositoryInterface 
{
    public function getByNome($nome);

    public function cadastrar($instituicaoEnsino, $nomeCidade);

    public function buscarInstituicoesSemMotorista($cidadeId);

    public function buscarInstituicoesSemVeiculo($cidadeId);

    public function buscarInstituicoesComRota($cidadeId);
}
