<?php

namespace App\Services;

use App\Repositories\Abstraction\EstudanteRepositoryInterface;
use App\Entities\Estudante;
use App\Entities\ComprovanteMatricula;
use App\Entities\HorarioSemanalEstudante;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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

        $this->estudanteRepository->
                associarComEntidades($estudante, $dados['pontosParada'], $dados['curso']['id'], $dados['endereco']);        
    }

    public function findById($id)
    {
        return $this->estudanteRepository->getById($id);
    }

    public function findByNumeroCelular($numeroCelular)
    {
        return $this->estudanteRepository->getByNumeroCelular($numeroCelular);
    }
    
    public function findByCidade($cidadeId)
    {        
        $result = $this->estudanteRepository->getByCidade($cidadeId);
        
        $estudantes = array();
        
        foreach ($result as $estudante) 
        {
            $estudantes[] = $estudante->toArray();
        }
        
        return $estudantes;
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
                
        $comprovanteMatricula = new ComprovanteMatricula();
        $comprovanteMatricula->setCaminhoSistemaArquivos($dados['comprovanteMatricula']['arquivo']);
        $comprovanteMatricula->setDataEnvio(Carbon::now());
        $comprovanteMatricula->setJustificativa($dados['comprovanteMatricula']['justificativa']);
        $comprovanteMatricula->setStatus($dados['comprovanteMatricula']['status']);
        
        $estudante->setComprovanteMatricula($comprovanteMatricula);

        $horariosSemanaisEstudante = [];
        
        foreach($dados['horariosSemanaisEstudante'] as $horario) 
        {
            $instanciaHorario = new HorarioSemanalEstudante();
            $instanciaHorario->setDiaSemana($horario['diaSemana']);
            $instanciaHorario->setEstudante($estudante);
            
            $horariosSemanaisEstudante[] = $instanciaHorario;
        }
        $estudante->setHorariosSemanaisEstudante($horariosSemanaisEstudante);
        
        return $estudante;
    }
}
