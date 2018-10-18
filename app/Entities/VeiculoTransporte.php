<?php

namespace App\Entities;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Traits\CriaArrayObjetoTrait;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="veiculos_transporte")
 */
class VeiculoTransporte 
{
    use CriaArrayObjetoTrait;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="integer", nullable=false) */
    protected $capacidade;

    /** @ORM\Column(type="string", nullable=false, unique=true) */
    protected $placa;

    /** @ORM\Column(type="string", nullable=false) */
    protected $tipo;

    /** @ORM\Column(type="string", nullable=false) */
    protected $cor;

    /** @ORM\Column(type="string", unique=true) */
    protected $imagem; // caminho no sistema de arquivos

    /** 
     * @ORM\JoinColumn(nullable=true)
     * @ORM\ManyToMany(targetEntity="InstituicaoEnsino", mappedBy="veiculosTransporte", fetch="EAGER") 
     */
    protected $instituicoesEnsino;

    public function __construct()
    {
        $this->instituicoesEnsino = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCapacidade()
    {
        return $this->capacidade;
    }

    public function getPlaca()
    {
        return $this->placa;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getCor()
    {
        return $this->cor;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function getInstituicoesEnsino()
    {
        return $this->instituicoesEnsino;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCapacidade($capacidade)
    {
        $this->capacidade = $capacidade;
    }

    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setCor($cor)
    {
        $this->cor = $cor;
    }

    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }

    public function setInstituicoesEnsino($instituicoesEnsino)
    {
        $this->instituicoesEnsino = $instituicoesEnsino;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'capacidade' => $this->capacidade,
            'placa' => $this->placa,
            'tipo' => $this->tipo,
            'cor' => $this->cor,
            'imagem' => $this->imagem,
            'instituicoesEnsino' => $this->instituicoesEnsino
         );
    }
}
