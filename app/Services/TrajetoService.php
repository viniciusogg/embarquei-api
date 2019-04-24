<?php

namespace App\Services;

use App\Entities\Cidade;
use App\Entities\Geolocalizacao;
use App\Entities\Rota;
use App\Repositories\Abstraction\TrajetoRepositoryInterface;
use App\Entities\Trajeto;
//use App\Entities\Enums\TIPO_TRAJETO;
use App\Entities\PontoParada;
use \App\Entities\HorarioTrajeto;
use Carbon\Carbon;

class TrajetoService extends Service
{
    private $trajetoRepository;

    public function __construct(TrajetoRepositoryInterface $trajetoRepository)
    {
        $this->trajetoRepository = $trajetoRepository;
    }

    public function create($dados)
    {
        $trajeto = $this->criarInstancia($dados);

        return $this->trajetoRepository->cadastrar($trajeto);
    }

    public function getTrajetosByCidadeInstituicaoRota($cidadeId, $instituicaoId)
    {  
        $result = $this->trajetoRepository->getTrajetosByCidadeInstituicaoRota($cidadeId, $instituicaoId);

        $trajetos = array();
        
        foreach ($result as $trajeto) 
        {
            $trajetos[] = $trajeto->toArray();
        }
        
        return $trajetos;
    }

    protected function criarInstancia($dados)
    {
        $rota = new Rota();
        $rota->setId($dados['rota']['id']);

        $cidade = new Cidade();
        $cidade->setId($dados['rota']['cidade']['id']);

        $rota->setCidade($cidade);

        $horaPartida = explode(':', $dados['horarioTrajeto']['partida'])[0];
        $minutoPartida = explode(':', $dados['horarioTrajeto']['partida'])[1];

        $horaChegada = explode(':', $dados['horarioTrajeto']['chegada'])[0];
        $minutoChegada = explode(':', $dados['horarioTrajeto']['chegada'])[1];

        $partida = Carbon::createFromTime($horaPartida, $minutoPartida);
        $chegada = Carbon::createFromTime($horaChegada, $minutoChegada);

        $horarioTrajeto = new HorarioTrajeto();

        if (isset($dados['horarioTrajeto']['id']))
        {
            $horarioTrajeto->setId($dados['horarioTrajeto']['id']);
        }
        $horarioTrajeto->setChegada($chegada);
        $horarioTrajeto->setPartida($partida);

        $trajeto = new Trajeto();
        $trajeto->setTipo($dados['tipo']);
        $trajeto->setDescricao($dados['descricao']);
        $trajeto->setAtivado($dados['ativado']);
        $trajeto->setHorarioTrajeto($horarioTrajeto);
        $trajeto->setRota($rota);

        foreach ($dados['pontosParada'] as $pontoParada)
        {
            $novoPontoParada = new PontoParada();
            $novoPontoParada->setNome($pontoParada['nome']);
            $novoPontoParada->setOrdem($pontoParada['ordem']);
            $novoPontoParada->setTrajeto($trajeto);

            if (isset($pontoParada['id']))
            {
                $novoPontoParada->setId($pontoParada['id']);
            }
            $geolocalizacao = new Geolocalizacao();

            if (isset($pontoParada['geolocalizacao']['id']))
            {
                $geolocalizacao->setId($pontoParada['geolocalizacao']['id']);
            }
            $geolocalizacao->setLat($pontoParada['geolocalizacao']['lat']);
            $geolocalizacao->setLng($pontoParada['geolocalizacao']['lng']);

            $novoPontoParada->setGeolocalizacao($geolocalizacao);

            $trajeto->getPontosParada()->add($novoPontoParada);
        }
        return $trajeto;
    }

    protected function getRepository()
    {
        return $this->trajetoRepository;
    }
}
