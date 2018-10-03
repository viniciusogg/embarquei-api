<?php

namespace App\Services;

use App\Repositories\Abstraction\RotaRepositoryInterface;
use App\Entities\Rota;
use App\Entities\Trajeto;
use App\Entities\HorarioTrajeto;
use App\Entities\PontoParada;

class RotaService 
{
    private $rotaRepository;

    public function __construct(RotaRepositoryInterface $rotaRepository)
    {
        $this->rotaRepository = $rotaRepository;
    }

    public function create($dados)
    {
        $rota = $this->criarInstanciaRota($dados);

        $this->rotaRepository->associarComEntidades($rota, $dados['nomesInstituicoesEnsino']);        
    }

    public function findById($id)
    {
        return $this->rotaRepository->getById($id);
    }

    public function findAll()
    {
        $result = $this->rotaRepository->getAll();

        $rotas = array();

        foreach ($result as $rota) {
            $rotas[] = $rota->toArray();
        }

        return $rotas;
    }

    public function update($dados, $id)
    {  
        $rota = $this->criarInstanciaRota($dados);
        $rota->setId($id);

        return  $this->rotaRepository->update($rota);
    }

    public function delete($id)
    {
        $this->rotaRepository->delete($id);
    }
    
    private function criarInstanciaRota($dados)
    {
        $rota = new Rota();
        $rota->setNome($dados['nome']);
//        $rota->setInstituicoesEnsino(null);   

        $pontosParada = [];
        $trajetos = [];
        
        foreach ($dados['trajetos'] as $trajeto)
        {
            $horarioTrajeto = new HorarioTrajeto();
            $horarioTrajeto->setPartida(new \DateTime($trajeto['horarioTrajeto']['partida']));
            $horarioTrajeto->setChegada(new \DateTime($trajeto['horarioTrajeto']['chegada']));//  Horário calculado a partir do horario de partida até chegar ao destino

            $novoTrajeto = new Trajeto();
            $novoTrajeto->setURLMapa($trajeto['urlMapa']);
            $novoTrajeto->setTipo($trajeto['tipoTrajeto']);
            $novoTrajeto->setHorarioTrajeto($horarioTrajeto);
            $novoTrajeto->setRota($rota);
            
            foreach ($trajeto['pontosParada'] as $pontoParada) 
            {
                $novoPontoParada = new PontoParada();
                $novoPontoParada->setNome($pontoParada['nome']);
                $novoPontoParada->setTrajeto($novoTrajeto);

                $pontosParada[] = $novoPontoParada;
            }
            $novoTrajeto->setPontosParada($pontosParada);
            
            $trajetos[] = $novoTrajeto;
        }        
        $rota->setTrajetos($trajetos);
                
        return $rota;
    }
}
