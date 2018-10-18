<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Traits\CriaArrayObjetoTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="instituicoes_ensino")
 */
class InstituicaoEnsino
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
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OneToMany(targetEntity="Curso", mappedBy="instituicaoEnsino", cascade={"all"}, fetch="EAGER")
     */
    protected $cursos;

    /**
     * @ORM\JoinColumn(nullable=false, unique=true)
     * @ORM\OneToOne(targetEntity="Endereco", cascade={"all"}, fetch="EAGER")
     */
    protected $endereco;

    /**
     * @ORM\JoinColumn(nullable=true)
     * @ORM\ManyToMany(targetEntity="Motorista", inversedBy="instituicoesEnsino", fetch="EAGER")
     */
    protected $motoristas; // GARANTIR QUE UMA INSTITUIÇÃO DE ENSINO SEMPRE VAI TER UM MOTORISTA

    /**
     * @ORM\JoinColumn(nullable=true)
     * @ORM\ManyToMany(targetEntity="VeiculoTransporte", inversedBy="instituicoesEnsino", fetch="EAGER")
     */
    protected $veiculosTransporte; // GARANTIR QUE UMA INSTITUIÇÃO DE ENSINO SEMPRE VAI TER UM VEICULO DE TRANSPORTE

    /**
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OneToMany(targetEntity="ListaPresenca", mappedBy="instituicaoEnsino", fetch="EAGER")
     */
    protected $listasPresenca;

    public function __construct()
    {
        $this->cursos = new ArrayCollection();
        $this->veiculosTransporte = new ArrayCollection();
        $this->motoristas = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getCursos()
    {
        return $this->cursos;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function getMotoristas()
    {
        return $this->motoristas;
    }

    public function getVeiculosTransporte()
    {
        return $this->veiculosTransporte;
    }

    public function getListasPresenca()
    {
        return $this->listasPresenca;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setCursos($cursos)
    {
        $this->cursos = $cursos;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function setMotoristas($motoristas)
    {
        $this->motoristas = $motoristas;
    }

    public function setVeiculosTransporte($veiculosTransporte)
    {
        $this->veiculosTransporte = $veiculosTransporte;
    }

    public function setListasPresenca($listasPresenca)
    {
        $this->listasPresenca = $listasPresenca;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cursos' => $this->retornarArrayObjetos($this->cursos),
            'endereco' => $this->endereco->toArray(),
//            'motoristas' => $this->retornarArrayObjetos($this->motoristas),
//            'veiculosTransporte' => $this->retornarArrayObjetos($this->veiculosTransporte),
//            'listasPresenca' => $this->retornarArrayObjetos($this->listasPresenca)
        ];
    }
    
}
