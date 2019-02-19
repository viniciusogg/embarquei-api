<?php

namespace App\Repositories\Abstraction;

interface RotaRepositoryInterface 
{
    public function associarComEntidades($rota, $nomesInstituicoesEnsino, $nomeCidade);

    public function getByInstituicaoCidade($instituicaoId, $cidadeId);
}
