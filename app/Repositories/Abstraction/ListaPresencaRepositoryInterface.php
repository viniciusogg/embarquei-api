<?php

namespace App\Repositories\Abstraction;

interface ListaPresencaRepositoryInterface
{
    public function cadastrar($listaPresenca, $cidadeId, $instituicaoId);
    
    public function adicionarAluno($checkinAluno, $cidadeId, $instituicaoId);
}
