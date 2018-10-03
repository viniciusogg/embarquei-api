<?php

namespace App\Services;

use App\Entities\Cidade;
use App\Repositories\Abstraction\CidadeRepositoryInterface;

class CidadeService 
{
    private $cidadeRepository;
    
    public function __construct(CidadeRepositoryInterface $cidadeRepository) 
    {
        $this->cidadeRepository = $cidadeRepository;
    }
    
    public function create($dados)
    {
        $cidade = $this->criarInstanciaCidade($dados);

        $this->cidadeRepository->create($cidade);
    }

    public function findById($id)
    {
        return $this->cidadeRepository->getById($id);
    }

    public function findAll()
    {
        $result = $this->cidadeRepository->getAll();

        $cidades = array();

        foreach ($result as $cidade) {
            $cidades[] = $cidade->toArray();
        }

        return $cidades;
    }
    
    public function findByNome($nome)
    {
        return $this->cidadeRepository->getByNome($nome);
    }

    public function update($dados, $id)
    {
        
        $cidade = $this->criarInstanciaCidade($dados);
        $cidade->setId($id);

        return  $this->cidadeRepository->update($cidade);
    }

    public function delete($id)
    {
        $this->cidadeRepository->delete($id);
    }
    
    private function criarInstanciaCidade($dados)
    {
        $cidade = new Cidade();
        $cidade->setNome($dados['nome']);
        
        return $cidade;
    }
}
