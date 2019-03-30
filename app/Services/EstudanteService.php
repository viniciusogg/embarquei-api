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
use App\Entities\Imagem;

class EstudanteService extends Service
{
    private $estudanteRepository;
    
    public function __construct(EstudanteRepositoryInterface $estudanteRepository)
    {
        $this->estudanteRepository = $estudanteRepository;
    }

    public function create($dados)
    {
        $estudante = $this->criarInstancia($dados);

        $estudanteSalvo = $this->estudanteRepository->
            cadastrar($estudante, $dados['pontosParada'], $dados['curso']['id'], $dados['endereco']);

        return $estudanteSalvo;
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

    public function update($dados, $id)
    {  
        $estudante = $this->criarInstancia($dados);
        $estudante->setId($id);
  
        $estudante = $this->estudanteRepository->
            atualizar($estudante, $dados['pontosParada'], $dados['curso']['id'], $dados['endereco']);

        return $estudante;
    }

    public function alterarStatus($id, $dados)
    {
        $estudante = $this->estudanteRepository->alterarStatus($id, $dados);

//        $checkin->setListaPresenca($listaPresenca)
        
//        $this->listaPresencaService->adicionarAluno($checkinAluno, $cidadeId, $instituicaoId);
        
        return $estudante;
    }
    
    protected function criarInstancia($dados)
    {
        $estudante = new Estudante();
        $estudante->setNome($dados['nome']);
        $estudante->setSobrenome($dados['sobrenome']);
        $estudante->setNumeroCelular($dados['numeroCelular']);
        $estudante->setBeta($dados['beta']);

        if (isset($dados['senha']) && Hash::needsRehash($dados['senha']))
        {
            $dados['senha'] = Hash::make($dados['senha']);
            $estudante->setSenha($dados['senha']);
        }
        $foto = new Imagem();

        if (isset($dados['foto']['id']))
        {
            $foto->setId($dados['foto']['id']);
        }
        $foto->setCaminhoSistemaArquivos($dados['foto']['caminhoSistemaArquivos']);

        $estudante->setFoto($foto);
        $estudante->setAtivo($dados['ativo']); //$dados['ativo']
                
        $comprovanteMatricula = new ComprovanteMatricula();
        
        if (isset($dados['comprovanteMatricula']['id']))
        {
            $comprovanteMatricula->setId($dados['comprovanteMatricula']['id']);

            $dataFormatada = date_create_from_format('d/m/Y H:i:s', $dados['comprovanteMatricula']['dataEnvio']);

            $dataEnvio = Carbon::createFromFormat('Y-m-d H:i:s', $dataFormatada->format('Y-m-d H:i:s'));

            $comprovanteMatricula->setDataEnvio($dataEnvio); // new DateTime($dados['comprovanteMatricula']['dataEnvio'])
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
        }
        $estudante->setHorariosSemanaisEstudante($horariosSemanaisEstudante);
        
        return $estudante;
    }

    protected function getRepository()
    {
        return $this->estudanteRepository;
    }
}
