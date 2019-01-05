<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="imagens")
 */
class Imagem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="string", nullable=false, unique=true) */
    protected $caminhoSistemaArquivos;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCaminhoSistemaArquivos()
    {
        return $this->caminhoSistemaArquivos;
    }

    /**
     * @param mixed $caminhoSistemaArquivos
     */
    public function setCaminhoSistemaArquivos($caminhoSistemaArquivos): void
    {
        $this->caminhoSistemaArquivos = $caminhoSistemaArquivos;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'caminhoSistemaArquivos' => $this->caminhoSistemaArquivos,
        );
    }
}