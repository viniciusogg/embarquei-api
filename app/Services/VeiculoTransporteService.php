<?php

namespace App\Services;

use App\Repositories\Abstraction\VeiculoTransporteRepositoryInterface;
use App\Entities\VeiculoTransporte;
use App\Services\Service;
use App\Entities\Imagem;

class VeiculoTransporteService extends Service
{
    private $veiculoTransporteRepository;

    public function __construct(VeiculoTransporteRepositoryInterface $veiculoTransporteRepository)
    {
        $this->veiculoTransporteRepository = $veiculoTransporteRepository;
    }

    public function create($dados)
    {
        $veiculo = $this->criarInstancia($dados);

        $this->veiculoTransporteRepository->cadastrar($veiculo, $dados['instituicoesEnsino'], $dados['cidade']['id']);
    }

    public function update($dados, $id)
    {
        $veiculo = $this->criarInstancia($dados);
        $veiculo->setId($id);

        return $this->getRepository()->
                atualizar($veiculo, $dados['instituicoesEnsino'], $dados['cidade']['id']);
    }

    public function findByCidade($cidadeId)
    {
        $result = $this->veiculoTransporteRepository->getByCidade($cidadeId);

        $veiculos = array();

        foreach ($result as $motorista)
        {
            $veiculos[] = $motorista->toArray();
        }
        return $veiculos;
    }

    protected function criarInstancia($dados)
    {
        $veiculoTransporte = new VeiculoTransporte();                
        $veiculoTransporte->setCapacidade($dados['capacidade']);
        $veiculoTransporte->setCor($dados['cor']);
        $veiculoTransporte->setPlaca($dados['placa']);
        $veiculoTransporte->setTipo($dados['tipo']);

        $foto = new Imagem();

        if (isset($dados['imagem']['id']))
        {
            $foto->setId($dados['imagem']['id']);
        }
        $foto->setCaminhoSistemaArquivos($dados['imagem']['caminhoSistemaArquivos']);

        $veiculoTransporte->setFoto($foto);
        $veiculoTransporte->setInstituicoesEnsino($dados['instituicoesEnsino']);
        
        return $veiculoTransporte;
    }

    protected function getRepository()
    {
        return $this->veiculoTransporteRepository;
    }
}
