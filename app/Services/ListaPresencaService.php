<?php

namespace App\Services;

use App\Repositories\Abstraction\ListaPresencaRepositoryInterface;
use App\Entities\ListaPresenca;
use Exception;

class ListaPresencaService 
{

    private $listaPresencaRepository;

    public function __construct(ListaPresencaRepositoryInterface $listaPresencaRepository)
    {
        $this->listaPresencaRepository = $listaPresencaRepository;
    }

    public function create($dados)
    {
        $listaPresenca = $this->criarInstanciaListaPresenca();

        $this->listaPresencaRepository->associarComEntitidades($listaPresenca, $dados['cidadeId'], $dados['instituicaoId']);
    }

    public function findById($id)
    {
        return $this->listaPresencaRepository->getById($id);
    }

    public function findAll()
    {
        $result = $this->listaPresencaRepository->getAll();

        $listasPresenca = array();

        foreach ($result as $listaPresenca) {
            $listasPresenca[] = $listaPresenca->toArray();
        }

        return $listasPresenca;
    }
    
    public function update($dados, $id)
    {
        $listaPresenca = $this->criarInstanciaListaPresencaRepository();
        $listaPresenca->setId($id);

        return  $this->listaPresencaRepository->update($dados, $listaPresenca);
    }

    public function delete($id)
    {
        $this->listaPresencaRepository->delete($id);
    }
    
    public function adicionarAluno($checkinAluno, $cidadeId, $instituicaoId)
    {
        $this->listaPresencaRepository->adicionarAluno($checkinAluno, $cidadeId, $instituicaoId);
    }
    
    private function criarInstanciaListaPresenca()
    {
        $listaPresenca = new ListaPresenca();               

        return $listaPresenca;
    }
}
