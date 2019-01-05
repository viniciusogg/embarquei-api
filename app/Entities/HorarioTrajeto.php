<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="horarios_trajeto")
 */
class HorarioTrajeto
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;
    
    /** @ORM\Column(type="time", nullable=false) */
    protected $partida;

    /** @ORM\Column(type="time", nullable=false) */    
    protected $chegada;
    
    public function getId() 
    {
        return $this->id;
    }

    public function getPartida() 
    {
        return $this->partida;
    }

    public function getChegada() 
    {
        return $this->chegada;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function setPartida($partida) 
    {
        $this->partida = $partida;
    }

    public function setChegada($chegada) 
    {
        $this->chegada = $chegada;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'partida' => $this->partida->format('H:i'),
            'chegada' => $this->chegada->format('H:i')
         );
    }
    
}
