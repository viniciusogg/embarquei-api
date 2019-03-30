<?php

namespace App\Services;

use App\Entities\Geolocalizacao;
use App\Repositories\Abstraction\InstituicaoEnsinoRepositoryInterface;
use App\Entities\InstituicaoEnsino;
use App\Entities\Endereco;
use App\Entities\Curso;

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
    
    protected function criarInstancia($dados)
    {
        $instituicaoEnsino = new InstituicaoEnsino();
        $instituicaoEnsino->setNome($dados['nome']);

        $endereco = new Endereco();
        $endereco->setLogradouro($dados['endereco']['logradouro']);
        $endereco->setBairro($dados['endereco']['bairro']);

        $geolocalizacao = new Geolocalizacao();
        $geolocalizacao->setLat($dados['geolocalizacao']['lat']);
        $geolocalizacao->setLng($dados['geolocalizacao']['lng']);

        $cursos = [];
        
        foreach($dados['cursos'] as $curso)
        {
            $novoCurso = new Curso();
            $novoCurso->setNome($curso['nome']);
            $novoCurso->setInstituicaoEnsino($instituicaoEnsino);
            
            $cursos[] = $novoCurso;
        }
        $instituicaoEnsino->setCursos($cursos);
        $instituicaoEnsino->setEndereco($endereco);
        $instituicaoEnsino->setGeolocalizacao($geolocalizacao);

        return $instituicaoEnsino;
    }

    protected function getRepository()
    {
        return $this->instituicaoEnsinoRepository;
    }
}
