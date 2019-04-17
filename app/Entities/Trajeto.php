<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Traits\CriaArrayObjetoTrait;
use App\Entities\Enums\TIPO_TRAJETO as TIPO_TRAJETO;
use App\Exceptions\ValorEnumInvalidoException;

/** @ORM\Entity */
class Trajeto 
{
    use CriaArrayObjetoTrait;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;


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
     * @ORM\ManyToOne(targetEntity="Rota", inversedBy="trajetos", cascade={"all"}, fetch="EAGER")
     */
    protected $rota;

    public function __construct()
    {
        $this->pontosParada = new ArrayCollection();
//        $this->pontosParada->
    }

    public function getId()
    {
        return $this->id;
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

    public function setTipo($tipo)
    {
        $tiposTrajeto = array(TIPO_TRAJETO::IDA, TIPO_TRAJETO::VOLTA);

        if (!in_array($tipo, $tiposTrajeto))
        {
            throw new ValorEnumInvalidoException("TIPO_TRAJETO");
        }
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
        $this->pontosParada = new ArrayCollection($pontosParada);
//        $this->getPontosParada()->filter();
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'tipo' => $this->tipo,
            'horarioTrajeto' => $this->horarioTrajeto->toArray(),
            'rota' => [
                'id' => $this->rota->getId()
            ],
            'pontosParada' => $this->retornarArrayObjetos($this->pontosParada)
         );
    }

}
