<?php

namespace App\Entities;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Traits\CriaArrayObjetoTrait;

/**  @ORM\Entity  */
class Cidade 
{
    use CriaArrayObjetoTrait;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="string", nullable=false, unique=true) */
    protected $nome;
    
    /** 
     * @ORM\JoinColumn(unique=true)
     * @ORM\OneToMany(targetEntity="Endereco", mappedBy="cidade", cascade={"remove"}, fetch="LAZY")
     */
    protected $enderecos;
    
    /**
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OneToMany(targetEntity="VeiculoTransporte", mappedBy="cidade", cascade={"remove"}, fetch="LAZY")
     */
    protected $veiculosTransporte;

    /**
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OneToOne(targetEntity="Geolocalizacao", cascade={"all"}, fetch="EAGER")
     */
    protected $geolocalizacao;

    public function __construct()
    {
        $this->enderecos = new ArrayCollection();
        $this->veiculosTransporte = new ArrayCollection();
    }
    
    public function getId() 
    {
        return $this->id;
    }

    public function getNome() 
    {
        return $this->nome;
    }

    public function getEnderecos() 
    {
        return $this->enderecos;
    }

    public function getVeiculosTransporte() 
    {
        return $this->veiculosTransporte;
    }

    public function getGeolocalizacao()
    {
        return $this->geolocalizacao;
    }

    public function setGeolocalizacao($geolocalizacao)
    {
        $this->geolocalizacao = $geolocalizacao;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function setNome($nome) 
    {
        $this->nome = $nome;
    }

    public function setEnderecos($enderecos) 
    {
        $this->enderecos = $enderecos;
    }

    public function setVeiculosTransporte($veiculosTransporte) 
    {
        $this->veiculosTransporte = $veiculosTransporte;
    }
    
    public function toArray()
    {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'geolocalizacao' => $this->geolocalizacao->toArray()
//            'enderecos' => $this->retornarArrayObjetos($this->enderecos),
//            'veiculosTransporte' => $this->retornarArrayObjetos($this->veiculosTransporte)
         );
    }
}
