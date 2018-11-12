<?php

namespace App\Repositories\Abstraction;

interface EstudanteRepositoryInterface 
{
    public function getByNumeroCelular($numeroCelular);

    public function getByCidade($cidadeId);
    
    public function associarComEntidades($estudante, $idsPontosParada, $idCurso, $endereco);
}
