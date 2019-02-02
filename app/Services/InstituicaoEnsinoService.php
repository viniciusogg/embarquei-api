<?php

namespace App\Services;

use App\Repositories\Abstraction\InstituicaoEnsinoRepositoryInterface;
use App\Entities\InstituicaoEnsino;
use App\Entities\Endereco;
use App\Entities\Curso;
use App\Services\Service;

class InstituicaoEnsinoService extends Service
{
    private $instituicaoEnsinoRepository;

    public function __construct(InstituicaoEnsinoRepositoryInterface $instituicaoEnsinoRepository)
    {
        $this->instituicaoEnsinoRepository = $instituicaoEnsinoRepository;
    }

    public function create($dados)
    {
        $instituicaoEnsino = $this->criarInstancia($dados);

        $this->instituicaoEnsinoRepository->cadastrar($instituicaoEnsino, $dados['endereco']['nomeCidade']);
    }

    public function findByNome($nome)
    {
        return $this->getRepository()->getByNome($nome);
    }

    public function buscarInstituicoesSemMotorista($cidadeId)
    {
        $result = $this->getRepository()->buscarInstituicoesSemMotorista($cidadeId);
        $instituicoes = array();

        foreach ($result as $instituicao) {
            $instituicoes[] = $instituicao->toArray();
        }
        return $instituicoes;
    }

    public function buscarInstituicoesSemVeiculo($cidadeId)
    {
        $result = $this->getRepository()->buscarInstituicoesSemVeiculo($cidadeId);
        $instituicoes = array();

        foreach ($result as $instituicao) {
            $instituicoes[] = $instituicao->toArray();
        }
        return $instituicoes;
    }

    public function buscarInstituicoesComRota($cidadeId)
    {
        $result = $this->getRepository()->buscarInstituicoesComRota($cidadeId);
        $instituicoes = array();

        foreach ($result as $instituicao) {
            $instituicoes[] = $instituicao->toArray();
        }
        return $instituicoes;
    }
    
    protected function criarInstancia($data)
    {
        $endereco = new Endereco();                
        $endereco->setLogradouro($data['endereco']['logradouro']);
        $endereco->setBairro($data['endereco']['bairro']);        
               
        $instituicaoEnsino = new InstituicaoEnsino();
        $instituicaoEnsino->setNome($data['nome']);

        $cursos = [];
        
        foreach($data['cursos'] as $curso) 
        {
            $novoCurso = new Curso();
            $novoCurso->setNome($curso['nome']);
            $novoCurso->setInstituicaoEnsino($instituicaoEnsino);
            
            $cursos[] = $novoCurso;
        }
        $instituicaoEnsino->setCursos($cursos);
        $instituicaoEnsino->setEndereco($endereco);
        
        return $instituicaoEnsino;
    }

    protected function getRepository()
    {
        return $this->instituicaoEnsinoRepository;
    }
}
