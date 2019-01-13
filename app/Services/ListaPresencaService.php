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

//    public function findById($id)
//    {
//        return $this->listaPresencaRepository->getById($id);
//    }

//    public function findAll()
//    {
//        $result = $this->listaPresencaRepository->getAll();
//
//        $listasPresenca = array();
//
//        foreach ($result as $listaPresenca) {
//            $listasPresenca[] = $listaPresenca->toArray();
//        }
//
//        return $listasPresenca;
//    }
    
    public function update($dados, $id)
    {
//        $listaPresenca = $this->criarInstanciaListaPresencaRepository();
//        $listaPresenca->setId($id);
//
//        return  $this->listaPresencaRepository->update($dados, $listaPresenca);
    }

    public function delete($id)
    {
//        $this->listaPresencaRepository->delete($id);
    }
    
    public function adicionarAluno($checkinAluno, $cidadeId, $instituicaoId)
    {
        $this->listaPresencaRepository->adicionarAluno($checkinAluno, $cidadeId, $instituicaoId);
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
