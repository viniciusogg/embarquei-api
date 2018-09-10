<?php

namespace App\Services;

use App\Repositories\Abstraction\MotoristaRepositoryInterface;
use App\Services\InstituicaoEnsinoService;
use App\Entities\Motorista;
use Illuminate\Support\Facades\Hash;

class MotoristaService 
{
    private $motoristaRepository;
    private $instituicaoEnsinoService;
    
    public function __construct(MotoristaRepositoryInterface $motoristaRepository,
            InstituicaoEnsinoService $instituicaoEnsinoService)
    {
        $this->motoristaRepository = $motoristaRepository;
        $this->instituicaoEnsinoService = $instituicaoEnsinoService;
    }

    public function create($data)
    {
        $motorista = $this->criarInstanciaMotorista($data);

        $this->instituicaoEnsinoService->associarComMotorista($motorista, $data['instituicoesEnsino']);        
    }

    public function findById($id)
    {
        return $this->motoristaRepository->getById($id);
    }

    public function findAll()
    {
        $result = $this->motoristaRepository->getAll();

        $motoristas = array();

        foreach ($result as $motorista) {
            $motoristas[] = $motorista->toArray();
        }

        return $motoristas;
    }

    public function update($data, $id)
    {
        // $senha = $data['senha'];

        if (Hash::needsRehash($data['senha']))
        {
            $data['senha'] = Hash::make($data['senha']);
        }

//        $usuario = new Usuario($data['nome'], $data['sobrenome'],
//                $data['numeroCelular'], $senha);
        
        $motorista = $this->criarInstanciaMotorista($data);
        $motorista->setId($id);

        return  $this->motoristaRepository->update($motorista);
    }

    public function delete($id)
    {
        $this->motoristaRepository->delete($id);
    }
    
    private function criarInstanciaMotorista($data)
    {
        $motorista = new Motorista();
        $motorista->setNome($data['nome']);
        $motorista->setSobrenome($data['sobrenome']);
        $motorista->setNumeroCelular($data['numeroCelular']);
        $motorista->setSenha(Hash::make($data['senha']));
        $motorista->setAtivo($data['ativo']); 
        $motorista->setFoto($data['foto']);        
                
        return $motorista;
    }
}
