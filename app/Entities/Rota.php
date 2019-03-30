<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Traits\CriaArrayObjetoTrait;

/** @ORM\Entity */
class Rota 
{
    use CriaArrayObjetoTrait;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    // NOME DEVE SER ÚNICO ENTRE AS ROTAS DO MUNICÍPIO
    /** @ORM\Column(type="string", nullable=false) */
    protected $nome;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToMany(targetEntity="InstituicaoEnsino", fetch="EAGER") 
     */
    protected $instituicoesEnsino;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OneToMany(targetEntity="Trajeto", mappedBy="rota", cascade={"all"}, fetch="EAGER") 
     */
    protected $trajetos;

    /**
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Cidade", fetch="EAGER")
     */
    protected $cidade;
    
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
    
    public function getCidade() 
    {
        return $this->cidade;
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

    public function setCidade($cidade) 
    {
        $this->cidade = $cidade;
    }
    
    public function toArray()
    {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'instituicoesEnsino' => $this->retornarArrayObjetos($this->instituicoesEnsino),
            'trajetos' => $this->retornarArrayObjetos($this->trajetos),
            'cidade' => [
                'id' => $this->cidade->getId(), 
                'nome' => $this->cidade->getNome()
            ]
         );
    }

}
