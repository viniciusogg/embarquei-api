<?php

namespace App\Repositories\Abstraction;

interface RotaRepositoryInterface 
{
    public function associarEPersistir($rota, $nomesInstituicoesEnsino, $idCidade);

    public function atualizar($rota, $instituicoesEnsino, $idCidade);

    public function getByInstituicaoCidade($instituicaoId, $cidadeId);

    public function getByCidade($cidadeId);
}
