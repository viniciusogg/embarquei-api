<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity */
class Trajeto {

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="string", nullable=false, name="url_mapa", unique=true) */
    protected $URLMapa;

    /** @ORM\Column(type="string", nullable=false) */
    protected $tipo;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OneToOne(targetEntity="HorarioTrajeto", cascade={"all"}, fetch="EAGER")
     */
    protected $horarioTrajeto;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OneToMany(targetEntity="PontoParada", mappedBy="trajeto", cascade={"all"}, fetch="EAGER") 
     */
    protected $pontosParada;

    /** 
     * @ORM\JoinColumn(nullable=false, name="rota_id")
     * @ORM\ManyToOne(targetEntity="Rota", inversedBy="trajetos", fetch="EAGER") 
     */
    protected $rota;

    public function __construct()
    {
        $this->pontosParada = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getURLMapa()
    {
        return $this->URLMapa;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getHorarioTrajeto()
    {
        return $this->horarioTrajeto;
    }

    public function getRota()
    {
        return $this->rota;
    }

    public function getPontosParada()
    {
        return $this->pontosParada;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setURLMapa($URLMapa)
    {
        $this->URLMapa = $URLMapa;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setHorarioTrajeto($horarioTrajeto)
    {
        $this->horarioTrajeto = $horarioTrajeto;
    }

    public function setRota($rota)
    {
        $this->rota = $rota;
    }
    
    public function setPontosParada($pontosParada)
    {
        $this->pontosParada = $pontosParada;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'URLMapa' => $this->URLMapa,
            'tipo' => $this->tipo,
            'horarioTrajeto' => $this->horarioTrajeto,
            'rota' => $this->rota,
            'pontosParada' => $this->pontosParada
         );
    }

}
