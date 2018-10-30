<?php

namespace App\Repositories\Abstraction;

interface PontoParadaRepositoryInterface
{

    public function getPontosParadaByCidadeInstituicaoRota($cidadeId, $instituicaoId, $rotaId);
}
