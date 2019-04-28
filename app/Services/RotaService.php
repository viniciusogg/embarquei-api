<?php

namespace App\Services;

use App\Entities\Geolocalizacao;
use App\Repositories\Abstraction\RotaRepositoryInterface;
use App\Entities\Rota;
use App\Entities\Trajeto;
use App\Entities\HorarioTrajeto;
use App\Entities\PontoParada;
use App\Exceptions\NullFieldException;
use Carbon\Carbon;

class RotaService extends Service
{
    private $rotaRepository;

    public function __construct(RotaRepositoryInterface $rotaRepository)
    {
        $this->rotaRepository = $rotaRepository;
    }

    public function create($dados)
    {
        $rota = $this->criarInstancia($dados);

        $this->rotaRepository->associarEPersistir($rota, $dados['instituicoesEnsino'], $dados['cidade']['id']);
    }

    public function findByInstituicaoCidade($instituicaoId, $cidadeId)
    {
        $rota = $this->rotaRepository->getByInstituicaoCidade($instituicaoId, $cidadeId);
//        error_log(json_encode($rota->toArray(), JSON_PRETTY_PRINT));
        return $rota;
    }

    public function findByCidade($cidadeId)
    {
        $resultado = $this->rotaRepository->getByCidade($cidadeId);
        $rotas = array();

        foreach ($resultado as $rota) {
            $rotas[] = $rota->toArray();
        }
        return $rotas;
    }

    public function update($dados, $id)
    {
        $rota = $this->criarInstancia($dados);
        $rota->setId($dados['id']);

        return $this->getRepository()->
                atualizar($rota, $dados['instituicoesEnsino'], $dados['cidade']['id']);
    }

    protected function criarInstancia($dados)
    {
        if (empty($dados['trajetos']))
        {
            throw new NullFieldException();
        }
        $rota = new Rota();

        foreach ($dados['trajetos'] as $trajeto)
        {
            $horaPartida = explode(':', $trajeto['horarioTrajeto']['partida'])[0];
            $minutoPartida = explode(':', $trajeto['horarioTrajeto']['partida'])[1];

            $horaChegada = explode(':', $trajeto['horarioTrajeto']['chegada'])[0];
            $minutoChegada = explode(':', $trajeto['horarioTrajeto']['chegada'])[1];

            $partida = Carbon::createFromTime($horaPartida, $minutoPartida);
            $chegada = Carbon::createFromTime($horaChegada, $minutoChegada);

            $horarioTrajeto = new HorarioTrajeto();

            if (isset($trajeto['horarioTrajeto']['id']))
            {
                $horarioTrajeto->setId($trajeto['horarioTrajeto']['id']);
            }
            $horarioTrajeto->setChegada($chegada);
            $horarioTrajeto->setPartida($partida);

            $novoTrajeto = new Trajeto();

            if (isset($trajeto['id']))
            {
                $novoTrajeto->setId($trajeto['id']);
            }
            $novoTrajeto->setDescricao($trajeto['descricao']);
            $novoTrajeto->setAtivado($trajeto['ativado']);
            $novoTrajeto->setTipo($trajeto['tipo']);
            $novoTrajeto->setHorarioTrajeto($horarioTrajeto);
            $novoTrajeto->setRota($rota);

            foreach ($trajeto['pontosParada'] as $pontoParada)
            {
                $novoPontoParada = new PontoParada();

                if (isset($pontoParada['id']))
                {
                    $novoPontoParada->setId($pontoParada['id']);
                }
                $novoPontoParada->setNome($pontoParada['nome']);
                $novoPontoParada->setOrdem($pontoParada['ordem']);
                $novoPontoParada->setTrajeto($novoTrajeto);

                $geolocalizacao = new Geolocalizacao();

                if (isset($pontoParada['geolocalizacao']['id']))
                {
                    $geolocalizacao->setId($pontoParada['geolocalizacao']['id']);
                }
                $geolocalizacao->setLat($pontoParada['geolocalizacao']['lat']);
                $geolocalizacao->setLng($pontoParada['geolocalizacao']['lng']);

                $novoPontoParada->setGeolocalizacao($geolocalizacao);

                $novoTrajeto->getPontosParada()->add($novoPontoParada);
            }
            $rota->getTrajetos()->add($novoTrajeto);
        }
        return $rota;
    }

    protected function getRepository()
    {
        return $this->rotaRepository;
    }
}
