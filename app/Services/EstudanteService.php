<?php

namespace App\Services;

use App\Repositories\Abstraction\EstudanteRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Estudante;
use App\Entities\ComprovanteMatricula;
use App\Entities\HorarioSemanalEstudante;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DateTime;

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
        $estudante = $this->criarInstanciaEstudante($dados);
        $estudante->setId($id);
  
        return  $this->estudanteRepository->
                atualizar($estudante, $dados['pontosParada'], $dados['curso']['id'], $dados['endereco']);
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
 
        if (isset($dados['senha']) && Hash::needsRehash($dados['senha']))
        {
            $dados['senha'] = Hash::make($dados['senha']);
            $estudante->setSenha($dados['senha']);
        }
        $estudante->setFoto($dados['foto']);
        $estudante->setAtivo($dados['ativo']);
                
        $comprovanteMatricula = new ComprovanteMatricula();
        
        if (isset($dados['comprovanteMatricula']['id']))
        {
            $comprovanteMatricula->setId($dados['comprovanteMatricula']['id']);
            $comprovanteMatricula->setDataEnvio(new DateTime($dados['comprovanteMatricula']['dataEnvio']));
//            $comprovanteMatricula->setDataEnvio(Carbon::now());         
        }
        else
        {
            $comprovanteMatricula->setDataEnvio(Carbon::now());            
        }
        $comprovanteMatricula->setCaminhoSistemaArquivos($dados['comprovanteMatricula']['caminhoSistemaArquivos']);
        $comprovanteMatricula->setJustificativa($dados['comprovanteMatricula']['justificativa']);
        $comprovanteMatricula->setStatus($dados['comprovanteMatricula']['status']);
        
        $estudante->setComprovanteMatricula($comprovanteMatricula);

        $horariosSemanaisEstudante = new ArrayCollection();
//        $horariosSemanaisEstudante = [];
        
        foreach($dados['horariosSemanaisEstudante'] as $horario) 
        {
            $instanciaHorario = new HorarioSemanalEstudante();
            
            if (isset($horario['id']))
            {
                $instanciaHorario->setId($horario['id']);
            }
            $instanciaHorario->setTemAula($horario['temAula']);
            $instanciaHorario->setDiaSemana($horario['diaSemana']);
            $instanciaHorario->setEstudante($estudante);
            
            $horariosSemanaisEstudante->add($instanciaHorario);
//            $horariosSemanaisEstudante[] = $instanciaHorario;            
        }
        $estudante->setHorariosSemanaisEstudante($horariosSemanaisEstudante);
        
        return $estudante;
    }
}
