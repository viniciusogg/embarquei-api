<?php

namespace App\Repositories\Abstraction;

interface MotoristaRepositoryInterface 
{
    public function cadastrar($motorista, $nomesInstituicoes, $cidadeId);

    public function atualizar($motorista, $nomesInstituicoes, $cidadeId);

    public function getByNumeroCelular($numeroCelular);

    public function getByCidade($idCidade);

    public function getByInstituicaoCidade($instituicaoId, $cidadeId);
}
