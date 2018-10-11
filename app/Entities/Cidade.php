<?php

namespace App\Entities;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**  @ORM\Entity  */
class Cidade 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="string", nullable=false, unique=true) */
    protected $nome;
    
    /** 
     * @ORM\JoinColumn(unique=true)
     * @ORM\OneToMany(targetEntity="Endereco", mappedBy="cidade", cascade={"remove"}, fetch="EAGER") 
     */
    protected $enderecos;

    public function __construct()
    {
        $this->enderecos = new ArrayCollection();
    }
    
    public function getId() 
    {
        return $this->id;
    }

    public function getNome() 
    {
        return $this->nome;
    }

    public function getEnderecos() 
    {
        return $this->enderecos;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function setNome($nome) 
    {
        $this->nome = $nome;
    }

    public function setEnderecos($enderecos) 
    {
        $this->enderecos = $enderecos;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id, 
            'nome' => $this->nome
         );
    }
}
