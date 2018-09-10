<?php

namespace App\Entities;

use App\Entities\Mensageiro;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity */
class Motorista extends Mensageiro {

    /** @ORM\Column(type="string") */
    protected $foto; // Caminho no sistema de arquivos

    /** 
     * @ORM\JoinColumn(nullable=true)
     * @ORM\ManyToMany(targetEntity="InstituicaoEnsino", mappedBy="motoristas") 
     */
    protected $instituicoesEnsino;

    public function __construct()
    {
        $this->instituicoesEnsino = new ArrayCollection();
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getInstituicoesEnsino()
    {
        return $this->instituicoesEnsino;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    public function setInstituicoesEnsino($instituicoesEnsino)
    {
        $this->instituicoesEnsino = $instituicoesEnsino;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'numeroCelular' => $this->numeroCelular,
            'foto' => $this->foto,
            'instituicoesEnsino' => $this->instituicoesEnsino
         );
    }
}
