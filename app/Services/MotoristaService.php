<?php

namespace App\Services;

use App\Repositories\Abstraction\MotoristaRepositoryInterface;
use App\Entities\Motorista;
use Illuminate\Support\Facades\Hash;

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
        
        $this->motoristaRepository->associarComInstituicao($motorista, $dados['instituicoesEnsino']);        
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
        // $senha = $data['senha'];

        if (Hash::needsRehash($dados['senha']))
        {
            $dados['senha'] = Hash::make($dados['senha']);
        }

//        $usuario = new Usuario($data['nome'], $data['sobrenome'],
//                $data['numeroCelular'], $senha);
        
        $motorista = $this->criarInstanciaMotorista($dados);
        $motorista->setId($id);

        return  $this->motoristaRepository->update($motorista);
    }

    public function delete($id)
    {
        $this->motoristaRepository->delete($id);
    }
    
    private function criarInstanciaMotorista($dados)
    {
        $motorista = new Motorista();
        $motorista->setNome($dados['nome']);
        $motorista->setSobrenome($dados['sobrenome']);
        $motorista->setNumeroCelular($dados['numeroCelular']);

        if (isset($dados['senha']) && Hash::needsRehash($dados['senha']))
        {
            $dados['senha'] = Hash::make($dados['senha']);
            $motorista->setSenha($dados['senha']);
        }

        $foto = new Imagem();

        if (isset($dados['foto']))
        {
            $foto->setId($dados['foto']['id']);
        }
        $foto->setCaminhoSistemaArquivos($dados['foto']['caminhoSistemaArquivos']);

        $motorista->setFoto($foto);

        $motorista->setAtivo($dados['ativo']);
        $motorista->setFoto($dados['foto']);        
                
        return $motorista;
    }
}
