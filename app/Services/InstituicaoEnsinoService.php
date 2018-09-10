<?php

namespace App\Services;

use App\Repositories\Abstraction\InstituicaoEnsinoRepositoryInterface;
use App\Entities\InstituicaoEnsino;
use App\Entities\Endereco;
use App\Entities\Curso;

class InstituicaoEnsinoService
{
    private $instituicaoEnsinoRepository;

    public function __construct(InstituicaoEnsinoRepositoryInterface $instituicaoEnsinoRepository)
    {
        $this->instituicaoEnsinoRepository = $instituicaoEnsinoRepository;
    }

    public function create($data)
    {
        $instituicaoEnsino = $this->criarInstanciaInstituicaoEnsino($data);

        $this->instituicaoEnsinoRepository->create($instituicaoEnsino);
    }

    public function findById($id)
    {
        return $this->instituicaoEnsinoRepository->getById($id);
    }

    public function findAll()
    {
        $result = $this->instituicaoEnsinoRepository->getAll();

        $instituicoesEnsino = array();

        foreach ($result as $instituicaoEnsino) {
            $instituicoesEnsino[] = $instituicaoEnsino->toArray();
        }

        return $instituicoesEnsino;
    }

    public function findByNome($nome)
    {
        return $this->instituicaoEnsinoRepository->getByNome($nome);
    }
    
    public function update($data, $id)
    {
        $instituicaoEnsino = $this->criarInstanciaInstituicaoEnsino($data);
        $instituicaoEnsino->setId($id);

        return  $this->instituicaoEnsinoRepository->update($instituicaoEnsino);
    }

    public function delete($id)
    {
        $this->instituicaoEnsinoRepository->delete($id);
    }
    
    public function associarComMotorista($dadosMotorista, $nomesInstituicoes)
    {
        $this->instituicaoEnsinoRepository->associarComMotorista($dadosMotorista, $nomesInstituicoes);
    }
    
    private function criarInstanciaInstituicaoEnsino($data)
    {
        $endereco = new Endereco();                
        $endereco->setCidade($data['endereco']['cidade']);
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
}
