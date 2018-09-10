<?php

namespace App\Services;

use App\Repositories\Abstraction\VeiculoTransporteRepositoryInterface;
use App\Services\InstituicaoEnsinoService;
use App\Entities\VeiculoTransporte;
use App\Entities\InstituicaoEnsino;

class VeiculoTransporteService 
{
//    private $instituicaoEnsinoService;
    private $veiculoTransporteRepository;

    public function __construct(VeiculoTransporteRepositoryInterface $veiculoTransporteRepository/*,
            InstituicaoEnsinoService $instituicaoEnsinoService*/)
    {
        //$this->instituicaoEnsinoService = $instituicaoEnsinoService;
        $this->veiculoTransporteRepository = $veiculoTransporteRepository;
    }

    public function create($data)
    {
        $veiculoTransporte = $this->criarInstanciaVeiculoTransporte($data);

        $this->veiculoTransporteRepository->create($veiculoTransporte);
    }

    public function findById($id)
    {
        return $this->veiculoTransporteRepository->getById($id);
    }

    public function findAll()
    {
        $result = $this->veiculoTransporteRepository->getAll();

        $veiculos = array();

        foreach ($result as $veiculo) {
            $veiculos[] = $veiculo->toArray();
        }

        return $veiculos;
    }

    public function update($data, $id)
    {
        $veiculos = $this->criarInstanciaVeiculoTransporte($data);
        $veiculos->setId($id);

        return  $this->veiculoTransporteRepository->update($veiculo);
    }

    public function delete($id)
    {
        $this->veiculoTransporteRepository->delete($id);
    }
    
    private function criarInstanciaVeiculoTransporte($data)
    {
        $veiculoTransporte = new VeiculoTransporte();                
        $veiculoTransporte->setCapacidade($data['capacidade']);
        $veiculoTransporte->setCor($data['cor']);
        $veiculoTransporte->setImagem($data['imagem']);
        $veiculoTransporte->setPlaca($data['placa']);
        $veiculoTransporte->setTipo($data['tipo']); 
        
        $veiculoTransporte->setInstituicoesEnsino($data['instituicoesEnsino']);
        
        return $veiculoTransporte;
    }
}
