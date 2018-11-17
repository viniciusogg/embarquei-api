<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Curso {

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="string", nullable=false) */
    protected $nome;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="InstituicaoEnsino", inversedBy="cursos", fetch="EAGER") 
     */
    protected $instituicaoEnsino;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getInstituicaoEnsino() {
        return $this->instituicaoEnsino;
    }

    public function setInstituicaoEnsino($instituicaoEnsino) {
        $this->instituicaoEnsino = $instituicaoEnsino;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'instituicaoEnsino' => [
                'id' => $this->instituicaoEnsino->getId(),
                'nome' => $this->instituicaoEnsino->getNome()
            ]
         );
    }
}
