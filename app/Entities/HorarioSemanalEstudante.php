<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Entities\Enums\DIA_SEMANA as DIA_SEMANA;
use App\Exceptions\ValorEnumInvalidoException;

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
        $diasSemana = array(DIA_SEMANA::SEGUNDA, DIA_SEMANA::TERCA,
            DIA_SEMANA::QUARTA, DIA_SEMANA::QUINTA, DIA_SEMANA::SEXTA);

        if (!in_array($diaSemana, $diasSemana))
        {
            throw new ValorEnumInvalidoException("DIA_SEMANA");
        }
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
//            'estudanteId' => $this->estudante->getId()
         );
    }
}
