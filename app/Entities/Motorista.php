<?php

namespace App\Entities;

use App\Entities\Mensageiro;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Traits\CriaArrayObjetoTrait;

/** @ORM\Entity */
class Motorista extends Mensageiro 
{
    use CriaArrayObjetoTrait;
    
    /**
     * @ORM\JoinColumn(nullable=false, unique=true)
     * @ORM\OneToOne(targetEntity="Imagem", cascade={"all"}, fetch="EAGER")
     */
    protected $foto; // Caminho no sistema de arquivos

    /**
     * @ORM\JoinColumn(nullable=true)
     * @ORM\ManyToOne(targetEntity="Cidade", fetch="EAGER")
     */
    protected $cidade;

    /** 
     * @ORM\JoinColumn(nullable=true)
     * @ORM\ManyToMany(targetEntity="InstituicaoEnsino", mappedBy="motoristas", fetch="EAGER") 
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

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade): void
    {
        $this->cidade = $cidade;
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
            'cidade' => $this->cidade->toArray(),
            'foto' => $this->foto->toArray(),
            'instituicoesEnsino' => $this->retornarArrayObjetos($this->instituicoesEnsino)
         );
    }
    
    private function retornarArrayObjetos($objetos)
    {
        $array = [];
        
        foreach ($objetos as $objeto)
        {
            $array[] = [
                'id' => $objeto->toArray()['id'],
                'nome' => $objeto->toArray()['nome']
            ];
        }
        return $array;
    }
}
