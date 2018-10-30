<?php

namespace App\Services;

use App\Entities\PontoParada;
use App\Repositories\Abstraction\PontoParadaRepositoryInterface;

class PontoParadaService 
{
     private $pontoParadaRepository;
    
    public function __construct(PontoParadaRepositoryInterface $pontoParadaRepository)
    {
        $this->pontoParadaRepository = $pontoParadaRepository;
    }

    public function create($dados)
    {
        $pontoParada = $this->criarInstanciaPontoParada($dados);
        
        $this->pontoParadaRepository->create($pontoParada);
    }

    public function findById($id)
    {
        return $this->pontoParadaRepository->getById($id);
    }
    
    public function findAll()
    {
        $result = $this->pontoParadaRepository->getAll();

        $pontosParada = array();

        foreach ($result as $pontoParada) {
            $pontosParada[] = $pontoParada->toArray();
        }

        return $pontosParada;
    }

    public function update($dados, $id)
    {       
        $pontoParada = $this->criarInstanciaPontoParada($dados);
        $pontoParada->setId($id);

        return  $this->pontoParadaRepository->update($pontoParada);
    }

    public function delete($id)
    {
        $this->pontoParadaRepository->delete($id);
    }
    
    private function criarInstanciaPontoParada($dados)
    {

    }
    
    public function getPontosParadaByCidadeInstituicaoRota($cidadeId, $instituicaoId, $rotaId)
    {
        $result = $this->pontoParadaRepository->getPontosParadaByCidadeInstituicaoRota($cidadeId, $instituicaoId, $rotaId);

        $pontosParada = array();
        
        foreach ($result as $pontoParada) 
        {
//            error_log($pontoParada->toArray());
            $pontosParada[] = $pontoParada->toArray();
        }
        
        return $pontosParada;
    }
}
