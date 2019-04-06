<?php

namespace App\Services;

use App\Entities\Geolocalizacao;
use App\Repositories\Abstraction\RotaRepositoryInterface;
use App\Entities\Rota;
use App\Entities\Trajeto;
use App\Entities\HorarioTrajeto;
use App\Entities\PontoParada;
use App\Exceptions\NullFieldException;

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

        $this->rotaRepository->associarEPersistir($rota, $dados['instituicoesEnsino'], $dados['cidade']);
    }

    public function findByInstituicaoCidade($instituicaoId, $cidadeId)
    {
        $rota = $this->rotaRepository->getByInstituicaoCidade($instituicaoId, $cidadeId);

        if ($rota)
        {
            $rota = $rota->toArray();
        }
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
    
    protected function criarInstancia($dados)
    {
        if (empty($dados['instituicoesEnsino']) || empty($dados['trajetos']))
        {
            throw new NullFieldException();
        }
        $rota = new Rota();
        $rota->setNome($dados['nome']);
//        $rota->setInstituicoesEnsino(null);   

        $pontosParada = [];
        $trajetos = [];
        
        foreach ($dados['trajetos'] as $trajeto)
        {
            $horarioTrajeto = new HorarioTrajeto();
            $horarioTrajeto->setPartida(new \DateTime($trajeto['horarioTrajeto']['partida']));
            $horarioTrajeto->setChegada(new \DateTime($trajeto['horarioTrajeto']['chegada']));//  Horário calculado a partir do horario de partida até chegar ao destino

            $novoTrajeto = new Trajeto();
            $novoTrajeto->setTipo($trajeto['tipo']);
            $novoTrajeto->setHorarioTrajeto($horarioTrajeto);
            $novoTrajeto->setRota($rota);
            
            foreach ($trajeto['pontosParada'] as $pontoParada) 
            {
                $novoPontoParada = new PontoParada();
                $novoPontoParada->setNome($pontoParada['nome']);
                $novoPontoParada->setOrdem($pontoParada['ordem']);
                $novoPontoParada->setTrajeto($novoTrajeto);

                $geolocalizacao = new Geolocalizacao();
                $geolocalizacao->setLat($pontoParada['geolocalizacao']['lat']);
                $geolocalizacao->setLng($pontoParada['geolocalizacao']['lng']);

                $novoPontoParada->setGeolocalizacao($geolocalizacao);

                $pontosParada[] = $novoPontoParada;
            }
            $novoTrajeto->setPontosParada($pontosParada);
            
            $trajetos[] = $novoTrajeto;
        }        
        $rota->setTrajetos($trajetos);
                
        return $rota;
    }

    protected function getRepository()
    {
        return $this->rotaRepository;
    }
}
