<?php

namespace App\Services;

use App\Repositories\Abstraction\MotoristaRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Entities\Motorista;
use App\Entities\Imagem;
use App\Services\Service;

class MotoristaService extends Service
{
    private $motoristaRepository;
    
    public function __construct(MotoristaRepositoryInterface $motoristaRepository)
    {
        $this->motoristaRepository = $motoristaRepository;
    }

    public function create($dados)
    {
        $motorista = $this->criarInstancia($dados);
        
        $this->motoristaRepository->cadastrar($motorista, $dados['instituicoesEnsino'], $dados['cidade']['id']);
    }

    public function findByNumeroCelular($numeroCelular)
    {
        return $this->motoristaRepository->getByNumeroCelular($numeroCelular);
    }

    public function update($dados, $id)
    {
        $motorista = $this->criarInstancia($dados);
        $motorista->setId($id);

        return $this->getRepository()->
                atualizar($motorista, $dados['instituicoesEnsino'], $dados['cidade']['id']);
    }

    public function findByInstituicaoCidade($instituicaoId, $cidadeId)
    {
        $motorista = $this->motoristaRepository->getByInstituicaoCidade($instituicaoId, $cidadeId);

        if ($motorista)
        {
            $motorista = $motorista->toArray();
        }
        return $motorista;
    }

    public function findByCidade($cidadeId)
    {
        $result = $this->getRepository()->getByCidade($cidadeId);

        $motoristas = array();

        foreach ($result as $motorista)
        {
            $motoristas[] = $motorista->toArray();
        }
        return $motoristas;
    }

    protected function criarInstancia($dados)
    {
        $motorista = new Motorista();
        $motorista->setNome($dados['nome']);
        $motorista->setSobrenome($dados['sobrenome']);
        $motorista->setNumeroCelular($dados['numeroCelular']);
        $motorista->setAtivo($dados['ativo']);
        $motorista->setBeta(true);

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
        else
        {
            $foto = null;
        }
        $motorista->setFoto($foto);

        return $motorista;
    }

    protected function getRepository()
    {
        return $this->motoristaRepository;
    }
}
