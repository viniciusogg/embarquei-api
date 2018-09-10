<?php

namespace App\Entities;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @ORM\Entity
 * @ORM\Table(name="renovacoes_cadastro")
 */
class RenovacaoCadastro {

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="boolean", nullable=false) */
    protected $ativa;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Administrador") 
     */
    protected $responsavel;

    /** @ORM\ManyToMany(targetEntity="Estudante") */
    protected $estudantes;

    public function __construct()
    {
        $this->estudantes = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAtiva()
    {
        return $this->ativa;
    }

    public function getResponsavel()
    {
        return $this->responsavel;
    }

    public function getEstudantes()
    {
        return $this->estudantes;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setAtiva($ativa)
    {
        $this->ativa = $ativa;
    }

    public function setResponsavel($responsavel)
    {
        $this->responsavel = $responsavel;
    }

    public function setEstudantes($estudantes)
    {
        $this->estudantes = $estudantes;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'ativa' => $this->ativa,
            'responsavel' => $this->responsavel,
            'estudantes' => $this->estudantes
         );
    }
}
