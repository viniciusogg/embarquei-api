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

        return $curso;
    }

    public function update($data, $id) { }

    public function delete($id) {}
    
    private function criarInstanciaCurso($data) {}
}
