<?php

namespace App\Repositories\Abstraction;

interface ListaPresencaRepositoryInterface
{
    public function associarComEntitidades($listaPresenca, $cidadeId, $instituicaoId);
    
    public function adicionarAluno($checkinAluno, $cidadeId, $instituicaoId);
}
