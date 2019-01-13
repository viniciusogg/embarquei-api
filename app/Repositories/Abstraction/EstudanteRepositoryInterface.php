<?php

namespace App\Repositories\Abstraction;

interface EstudanteRepositoryInterface 
{
    public function getByNumeroCelular($numeroCelular);

    public function getByCidade($cidadeId);
    
    public function cadastrar($estudante, $idsPontosParada, $idCurso, $endereco);
    
    public function atualizar($estudante, $idsPontosParada, $idCurso, $endereco);
    
    public function alterarStatus($id, $status);
}
