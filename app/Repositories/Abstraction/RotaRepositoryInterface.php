<?php

namespace App\Repositories\Abstraction;

interface RotaRepositoryInterface 
{
    public function associarEPersistir($rota, $nomesInstituicoesEnsino, $nomeCidade);

    public function getByInstituicaoCidade($instituicaoId, $cidadeId);
}
