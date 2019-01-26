<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Entities\Enums\STATUS_COMPROVANTE as STATUS_COMPROVANTE;
use App\Exceptions\ValorEnumInvalidoException;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="comprovantes_matricula")
 */
class ComprovanteMatricula
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

    /** @ORM\Column(type="string", nullable=false) */
    protected $status;

    /** @ORM\Column(type="datetime", nullable=false) */
    protected $dataEnvio;

    /** @ORM\Column(type="string") */
    protected $justificativa;

    public function getCaminhoSistemaArquivos()
    {
        return $this->caminhoSistemaArquivos;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getDataEnvio()
    {
        return $this->dataEnvio;
    }

    public function getJustificativa()
    {
        return $this->justificativa;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCaminhoSistemaArquivos($caminhoSistemaArquivos)
    {
        $this->caminhoSistemaArquivos = $caminhoSistemaArquivos;
    }

    public function setStatus($status)
    {
        $tiposStatusComprovante = array(STATUS_COMPROVANTE::APROVADO,
            STATUS_COMPROVANTE::EM_ANALISE, STATUS_COMPROVANTE::RECUSADO);

        if (!in_array($status, $tiposStatusComprovante))
        {
            throw new ValorEnumInvalidoException("STATUS_COMPROVANTE");
        }
        $this->status = $status;
    }

    public function setDataEnvio($dataEnvio)
    {
        $this->dataEnvio = $dataEnvio;
    }

    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'caminhoSistemaArquivos' => $this->caminhoSistemaArquivos,
            'status' => $this->status,
            'dataEnvio' => $this->dataEnvio->format('d/m/Y H:i:s'),
            'justificativa' => $this->justificativa,
         );
    }
}
