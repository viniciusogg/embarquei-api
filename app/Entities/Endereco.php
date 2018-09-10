<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Endereco {

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;
    
    /** @ORM\Column(type="string", nullable=false) */
    protected $cidade;
    
    /** @ORM\Column(type="string", nullable=false) */
    protected $logradouro;
    
    /** @ORM\Column(type="string", nullable=false) */
    protected $bairro;
 
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    public function getLogradouro() 
    {
        return $this->logradouro;
    }

    public function setLogradouro($logradouro) 
    {
        $this->logradouro = $logradouro;
    }

    public function getBairro() 
    {
        return $this->bairro;
    }

    public function setBairro($bairro) 
    {
        $this->bairro = $bairro;
    }    

    public function toArray()
    {
        return array(
            'id' => $this->id, 
            'cidade' => $this->cidade, 
            'logradouro' => $this->logradouro, 
            'bairro' => $this->bairro
         );
    }
}
