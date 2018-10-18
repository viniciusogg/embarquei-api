<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Checkin 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="boolean", nullable=false) */
    protected $confirmado;

    /** 
     * @ORM\JoinColumn(nullable=false, unique=true)
     * @ORM\OneToOne(targetEntity="Estudante") 
     */
    protected $estudante;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="ListaPresenca", inversedBy="checkins") 
     */
    protected $listaPresenca;

    public function getId() {
        return $this->id;
    }

    public function getConfirmado()
    {
        return $this->confirmado;
    }

    public function getEstudante()
    {
        return $this->estudante;
    }

    public function getListaPresenca()
    {
        return $this->listaPresenca;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;
    }

    public function setEstudante($estudante)
    {
        $this->estudante = $estudante;
    }

    public function setListaPresenca($listaPresenca)
    {
        $this->listaPresenca = $listaPresenca;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'confirmado' => $this->confirmado,
            'estudante' => $this->estudante,
            'listaPresenca' => $this->listaPresenca->getId()
         );
    }
}
