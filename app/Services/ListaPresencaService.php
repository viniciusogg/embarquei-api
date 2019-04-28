<?php

namespace App\Services;

use App\Repositories\Abstraction\ListaPresencaRepositoryInterface;
use App\Entities\ListaPresenca;
use App\Services\Service;
use Exception;

class ListaPresencaService extends Service
{
    private $listaPresencaRepository;

    public function __construct(ListaPresencaRepositoryInterface $listaPresencaRepository)
    {
        $this->listaPresencaRepository = $listaPresencaRepository;
    }

    public function create($dados)
    {
        $listaPresenca = $this->criarInstancia(null);

        $this->listaPresencaRepository->cadastrar($listaPresenca, $dados['cidadeId'], $dados['instituicaoId']);
    }

    public function filtrarPorInstituicaoMotorista($idMotorista)
    {
        $result = $this->getRepository()->filtrarPorInstituicaoMotorista($idMotorista);

        $listasPresenca = array();

        foreach ($result as $listaPresenca)
        {
            $listasPresenca[] = $listaPresenca;
        }
        return $listasPresenca;
    }

    public function filtrarPorInstituicaoRota($idInstituicao)
    {
        $result = $this->getRepository()->filtrarPorInstituicaoRota($idInstituicao);

        $listasPresenca = array();

        foreach ($result as $listaPresenca)
        {
            $listasPresenca[] = $listaPresenca;
        }
        return $listasPresenca;
    }

    protected function getRepository()
    {
        return $this->listaPresencaRepository;
    }

    protected function criarInstancia($dados)
    {
        $listaPresenca = new ListaPresenca();               

        return $listaPresenca;
    }
}
