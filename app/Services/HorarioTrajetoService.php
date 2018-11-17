<?php

namespace App\Services;

use App\Repositories\Abstraction\HorarioTrajetoRepositoryInterface;
use App\Entities\HorarioTrajeto;
use Carbon\Carbon;
use DateTime;

class HorarioTrajetoService 
{
    private $horarioTrajetoRepository;

    public function __construct(HorarioTrajetoRepositoryInterface $horarioTrajetoRepository)
    {
        $this->horarioTrajetoRepository = $horarioTrajetoRepository;
    }

    public function create($dados)
    {
        $horarioTrajeto = $this->criarInstanciaHorarioTrajeto($dados);

        $this->horarioTrajetoRepository->create($horarioTrajeto);
    }

    public function findById($id)
    {
        return $this->horarioTrajetoRepository->getById($id);
    }

    public function findAll()
    {
        $result = $this->horarioTrajetoRepository->getAll();

        $horariosTrajeto = array();

        foreach ($result as $horarioTrajeto) {
            $horariosTrajeto[] = $horarioTrajeto->toArray();
        }

        return $horariosTrajeto;
    }

    public function findByNome($nome)
    {
        return $this->horarioTrajetoRepository->getByNome($nome);
    }
    
    public function update($dados, $id)
    {
        $horarioTrajeto = $this->criarInstanciaHorarioTrajeto($dados);
        $horarioTrajeto->setId($id);

        return  $this->horarioTrajetoRepository->update($horarioTrajeto);
    }

    public function delete($id)
    {
        $this->horarioTrajetoRepository->delete($id);
    }
    
    private function criarInstanciaHorarioTrajeto($dados)
    {
//        error_log($chegada->format('H:i'));
        
        $horarioTrajeto = new HorarioTrajeto();
        $horarioTrajeto->setChegada(new DateTime($dados['chegada'])); 
        $horarioTrajeto->setPartida(new DateTime($dados['partida']));
        
        return $horarioTrajeto;
    }
}
