<?php

namespace App\Services;

use App\Repositories\Abstraction\CursoRepositoryInterface;

class CursoService 
{
    private $cursoRepository;

    public function __construct(CursoRepositoryInterface $cursoRepository)
    {
        $this->cursoRepository = $cursoRepository;
    }

    public function create($data) {}

    public function findById($id)
    {
        return $this->cursoRepository->getById($id);
    }

    public function findAll()
    {
        $result = $this->cursoRepository->getAll();

        $cursos = array();

        foreach ($result as $curso) {
            $cursos[] = $curso->toArray();
        }

        return $cursos;
    }

    public function update($dados, $id) 
    { 
        $curso = $this->criarInstanciaCurso($dados);
        $curso->setId($id);

        return  $this->cursoRepository->update($curso);
    }

    public function delete($id) 
    {
        $this->cidadeRepository->delete($id);
    }
    
    private function criarInstanciaCurso($dados) {}
}
