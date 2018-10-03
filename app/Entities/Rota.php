<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity */
class Rota {

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
     * @ORM\ManyToMany(targetEntity="InstituicaoEnsino") 
     */
    protected $instituicoesEnsino;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OneToMany(targetEntity="Trajeto", mappedBy="rota", cascade={"all"}) 
     */
    protected $trajetos;

    public function __construnct()
    {
        $this->instituicoesEnsino = new ArrayCollection();
        $this->trajetos = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getInstituicoesEnsino()
    {
        return $this->instituicoesEnsino;
    }

    public function getTrajetos()
    {
        return $this->trajetos;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setInstituicoesEnsino($instituicoesEnsino)
    {
        $this->instituicoesEnsino = $instituicoesEnsino;
    }

    public function setTrajetos($trajetos)
    {
        $this->trajetos = $trajetos;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'instituicoesEnsino' => $this->instituicoesEnsino,
            'trajetos' => $this->trajetos
         );
    }

}
