<?php

namespace App\Services;

use App\Repositories\Abstraction\EstudanteRepositoryInterface;
use App\Entities\Estudante;
use Illuminate\Support\Facades\Hash;

class EstudanteService 
{
    private $estudanteRepository;

    public function __construct(EstudanteRepositoryInterface $estudanteRepository)
    {
        $this->estudanteRepository = $estudanteRepository;
    }

    public function create($data)
    {
        $estudante = $this->criarInstanciaEstudante($data);

        $this->estudanteRepository->create($estudante);
    }

    public function findById($id)
    {
        return $this->estudanteRepository->getById($id);
    }

    public function findAll()
    {
        $result = $this->estudanteRepository->getAll();

        $estudantes = array();

        foreach ($result as $estudante) {
            $estudantes[] = $estudante->toArray();
        }

        return $estudantes;
    }

    public function update($data, $id)
    {
        // $senha = $data['senha'];

        if (Hash::needsRehash($data['senha']))
        {
            $data['senha'] = Hash::make($data['senha']);
        }

//        $usuario = new Usuario($data['nome'], $data['sobrenome'],
//                $data['numeroCelular'], $senha);
        
        $estudante = $this->criarInstanciaEstudante($data);
        $estudante->setId($id);

        return  $this->estudanteRepository->update($estudante);
    }

    public function delete($id)
    {
        $this->estudanteRepository->delete($id);
    }
    
    private function criarInstanciaEstudante($data)
    {
        $estudante = new Estudante();

        $estudante->setNome($data['nome']);
        $estudante->setSobrenome($data['sobrenome']);
        $estudante->setNumeroCelular($data['numeroCelular']);
        $estudante->setSenha(Hash::make($data['senha']));
        $estudante->setFoto($data['foto']);
        $estudante->setAtivo($data['ativo']);
        
        $estudante->setComprovateMatricula($data['comprovateMatricula']);
        $estudante->setCurso($data['curso']); // FAZER UMA ASSOCIAÇÃO COM CURSO JÁ EXISTENTE E ATUALIZAR
        $estudante->setEndereco($data['endereco']);
        $estudante->setHorariosSemanaisEstudante($data['horariosSemanaisEstudante']);
        $estudante->setPontosParada($data['pontosParada']); // FAZER UMA ASSOCIAÇÃO COM CURSO JÁ EXISTENTE E ATUALIZAR
        
        return $estudante;
    }
}
