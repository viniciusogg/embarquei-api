<?php

namespace App\Services;

use App\Entities\Cidade;
use App\Entities\Geolocalizacao;
use App\Repositories\Abstraction\CidadeRepositoryInterface;

class CidadeService extends Service
{
    private $cidadeRepository;
    
    public function __construct(CidadeRepositoryInterface $cidadeRepository) 
    {
        $this->cidadeRepository = $cidadeRepository;
    }
    
    public function findByNome($nome)
    {
        return $this->cidadeRepository->getByNome($nome);
    }

    public function buscarCidadesComRotas()
    {
        $result = $this->cidadeRepository->buscarCidadesComRotas();

        return $this->criarArrayCidades($result);
    }
    
    protected function criarInstancia($dados)
    {
        $cidade = new Cidade();
        $cidade->setNome($dados['nome']);

        $geolocalizacao = new Geolocalizacao();
        $geolocalizacao->setLat($dados['geolocalizacao']['lat']);
        $geolocalizacao->setLat($dados['geolocalizacao']['lng']);

        $cidade->setGeolocalizacao($geolocalizacao);
        
        return $cidade;
    }

    protected function getRepository()
    {
        return $this->cidadeRepository;
    }

    private function criarArrayCidades($dados)
    {
        $cidades = array();

        foreach ($dados as $cidade) {
            $cidades[] = $cidade->toArray();
        }        
        return $cidades;
    }
}
