<?php

namespace App\Repositories\Abstraction;

interface VeiculoTransporteRepositoryInterface
{

    public function cadastrar($veiculoTransporte, $instituicoesEnsino, $cidadeId);

    public function atualizar($veiculo, $instituicoesEnsino, $cidadeId);

    public function getByCidade($cidadeId);
}
