<?php

namespace App\Services;

use App\Repositories\Abstraction\MotoristaRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Entities\Motorista;
use App\entities\Imagem;

class MotoristaService 
{
    private $motoristaRepository;
    
    public function __construct(MotoristaRepositoryInterface $motoristaRepository)
    {
        $this->motoristaRepository = $motoristaRepository;
    }

    public function create($dados)
    {
        $motorista = $this->criarInstanciaMotorista($dados);
        
        $this->motoristaRepository->cadastrar($motorista, $dados['instituicoesEnsino'], $dados['cidade']['id']);
    }

    public function findById($id)
    {
        return $this->motoristaRepository->getById($id);
    }

    public function findByNumeroCelular($numeroCelular)
    {
        return $this->motoristaRepository->getByNumeroCelular($numeroCelular);
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

    public function update($dados, $id)
    {
        $motorista = $this->criarInstanciaMotorista($dados);
        $motorista->setId($id);

        return  $this->motoristaRepository->update($motorista);
    }

    public function delete($id)
    {
        $this->motoristaRepository->delete($id);
    }

    public function findByCidade($cidadeId)
    {
        $result = $this->motoristaRepository->getByCidade($cidadeId);

        $motoristas = array();

        foreach ($result as $motorista)
        {
            $motoristas[] = $motorista->toArray();
        }
        return $motoristas;
    }

    private function criarInstanciaMotorista($dados)
    {
        $motorista = new Motorista();
        $motorista->setNome($dados['nome']);
        $motorista->setSobrenome($dados['sobrenome']);
        $motorista->setNumeroCelular($dados['numeroCelular']);
        $motorista->setAtivo(true);

        if (isset($dados['senha']) && Hash::needsRehash($dados['senha']))
        {
            $dados['senha'] = Hash::make($dados['senha']);
            $motorista->setSenha($dados['senha']);
        }
        else
        {
            $motorista->setSenha(Hash::make(env('SENHA_PADRAO')));
        }
        $foto = new Imagem();

        if (isset($dados['foto']['id']))
        {
            $foto->setId($dados['foto']['id']);
        }
        else if (isset($dados['foto']))
        {
            $foto->setCaminhoSistemaArquivos($dados['foto']['caminhoSistemaArquivos']);
        }
        $motorista->setFoto($foto);

        return $motorista;
    }
}
