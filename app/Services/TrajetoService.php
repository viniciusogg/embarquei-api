<?php

namespace App\Services;

use App\Repositories\Abstraction\TrajetoRepositoryInterface;
use App\Entities\Trajeto;
//use App\Entities\Enums\TIPO_TRAJETO;
use App\Entities\PontoParada;
use \App\Entities\HorarioTrajeto;

class TrajetoService 
{
    private $trajetoRepository;

    public function __construct(TrajetoRepositoryInterface $trajetoRepository)
    {
        $this->trajetoRepository = $trajetoRepository;
    }

    public function create($dados)
    {
        $trajeto = $this->criarInstanciaTrajeto($dados);

        $this->trajetoRepository->associarComRota($trajeto, $dados['rota']);        
    }

    public function findById($id)
    {
        return $this->trajetoRepository->getById($id);
    }

    public function findAll()
    {
        $result = $this->trajetoRepository->getAll();

        $trajetos = array();

        foreach ($result as $trajeto) {
            $trajetos[] = $trajeto->toArray();
        }

        return $trajetos;
    }

    public function update($dados, $id)
    {  
        $trajeto = $this->criarInstanciaTrajeto($dados);
        $trajeto->setId($id);

        return  $this->trajetoRepository->update($estudante);
    }

    public function delete($id)
    {
        $this->trajetoRepository->delete($id);
    }
    
    private function criarInstanciaTrajeto($dados)
    {
        $horarioTrajeto = new HorarioTrajeto();
        $horarioTrajeto->setPartida($dados['horarioTrajeto']['partida']);
        $horarioTrajeto->setChegada($dados['horarioTrajeto']['chegada']);
        
        $trajeto = new Trajeto();
        $trajeto->setURLMapa($dados['urlMapa']);
        $trajeto->setTipo($dados['tipoTrajeto']);
        $trajeto->setHorarioTrajeto($horarioTrajeto);
        
        $pontosParada = [];
                
        foreach ($dados['pontosParada'] as $pontoParada) 
        {
            $novoPontoParada = new PontoParada();
            $novoPontoParada->setNome($pontoParada['nome']);
            $novoPontoParada->setTrajeto($trajeto);
            
            $pontosParada[] = $novoPontoParada;
        }
        
        $trajeto->setPontosParada($pontosParada);
                
        return $trajeto;
    }
}
