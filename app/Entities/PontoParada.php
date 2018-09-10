<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="pontos_parada")
 */
class PontoParada {

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $nome;

    /** 
     * @ORM\JoinColumn(nullable=true)
     * @ORM\ManyToMany(targetEntity="Estudante", mappedBy="pontosParada") 
     */
    protected $estudantes;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Trajeto", inversedBy="pontosParada") 
     */
    protected $trajeto;

    public function __construct()
    {
        $this->estudantes = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getTrajeto()
    {
        return $this->trajeto;
    }

    public function getEstudantes()
    {
        return $this->estudantes;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setEstudantes($estudantes)
    {
        $this->estudantes = $estudantes;
    }

    public function setTrajeto($trajeto)
    {
        $this->trajeto = $trajeto;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'estudantes' => $this->estudantes,
            'trajeto' => $this->trajeto
         );
    }
}
