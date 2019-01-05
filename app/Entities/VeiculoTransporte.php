<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Traits\CriaArrayObjetoTrait;
use App\Entities\Enums\TIPO_VEICULO as TIPO_VEICULO;
use App\Exceptions\ValorEnumInvalidoException;

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

    /**
     * @ORM\JoinColumn(nullable=true, unique=true)
     * @ORM\OneToOne(targetEntity="Imagem", cascade={"all"}, fetch="EAGER")
     */
    protected $foto; // caminho no sistema de arquivos

    /** 
     * @ORM\JoinColumn(nullable=true)
     * @ORM\ManyToMany(targetEntity="InstituicaoEnsino", mappedBy="veiculosTransporte", fetch="EAGER") 
     */
    protected $instituicoesEnsino;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Cidade", inversedBy="veiculosTransporte", fetch="EAGER") 
     */
    protected $cidade;
    
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

    public function getFoto()
    {
        return $this->foto;
    }

    public function getInstituicoesEnsino()
    {
        return $this->instituicoesEnsino;
    }

    public function getCidade() 
    {
        return $this->cidade;
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
        $tiposVeiculos = array(TIPO_VEICULO::ONIBUS, TIPO_VEICULO::VAN);

        if (!in_array($tipo, $tiposVeiculos))
        {
            throw new ValorEnumInvalidoException("TIPO_VEICULO");
        }
        $this->tipo = $tipo;
    }

    public function setCor($cor)
    {
        $this->cor = $cor;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    public function setInstituicoesEnsino($instituicoesEnsino)
    {
        $this->instituicoesEnsino = $instituicoesEnsino;
    }
    
    public function setCidade($cidade) 
    {
        $this->cidade = $cidade;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'capacidade' => $this->capacidade,
            'placa' => $this->placa,
            'tipo' => $this->tipo,
            'cor' => $this->cor,
            'foto' => $this->foto->toArray(),
            'instituicoesEnsino' => $this->retornarArrayObjetos($this->instituicoesEnsino),
            'cidade' => $this->cidade->id
         );
    }
}
