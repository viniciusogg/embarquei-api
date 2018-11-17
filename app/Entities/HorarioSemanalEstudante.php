<?php

namespace App\Entities;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="horarios_semanais_estudantes")
 */
class HorarioSemanalEstudante {

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="string", nullable=false) */
    protected $diaSemana;

    /** @ORM\Column(type="boolean", nullable=false) */
    protected $temAula;
    
    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Estudante", inversedBy="horariosSemanaisEstudante") 
     */
    protected $estudante;

    public function getId()
    {
        return $this->id;
    }

    public function getDiaSemana()
    {
        return $this->diaSemana;
    }

    public function getTemAula()
    {
        return $this->temAula;
    }
    
    public function getEstudante()
    {
        return $this->estudante;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDiaSemana($diaSemana)
    {
        $this->diaSemana = $diaSemana;
    }
    
    public function setTemAula($temAula)
    {
        $this->temAula = $temAula;
    }

    public function setEstudante($estudante)
    {
        $this->estudante = $estudante;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'diaSemana' => $this->diaSemana,
            'temAula' => $this->temAula,
            'estudante' => $this->estudante->getId()
         );
    }
}
