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

    public function create($dados)
    {
        $estudante = $this->criarInstanciaEstudante($dados);

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

    public function update($dados, $id)
    {
        if (Hash::needsRehash($dados['senha']))
        {
            $dados['senha'] = Hash::make($dados['senha']);
        }
        
        $estudante = $this->criarInstanciaEstudante($dados);
        $estudante->setId($id);

        return  $this->estudanteRepository->update($estudante);
    }

    public function delete($id)
    {
        $this->estudanteRepository->delete($id);
    }
    
    private function criarInstanciaEstudante($dados)
    {
        $estudante = new Estudante();

        $estudante->setNome($dados['nome']);
        $estudante->setSobrenome($dados['sobrenome']);
        $estudante->setNumeroCelular($dados['numeroCelular']);
        $estudante->setSenha(Hash::make($dados['senha']));
        $estudante->setFoto($dados['foto']);
        $estudante->setAtivo($dados['ativo']);
        
        $estudante->setEndereco($dados['endereco']); // CASCATA
        
        $estudante->setComprovateMatricula($dados['comprovateMatricula']); // CASCATA
        $estudante->setPontosParada($dados['pontosParada']); // ESTUDANTE É DONO DA ASSOCIAÇÃO
        
        $estudante->setCurso($dados['curso']); // FAZER UMA ASSOCIAÇÃO COM CURSO JÁ EXISTENTE E ATUALIZAR
        $estudante->setHorariosSemanaisEstudante($dados['horariosSemanaisEstudante']); // CASCATA (HorarioSeman... é dono da associação)
        
        return $estudante;
    }
}
