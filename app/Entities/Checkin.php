<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Entities\Enums\STATUS_CHECKIN as STATUS_CHECKIN;
use App\Exceptions\ValorEnumInvalidoException;

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

    /** @ORM\Column(type="string", nullable=false) */
    protected $status;

    /** @ORM\Column(type="datetime", nullable=false) */
    protected $dataUltimaAtualizacao;

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

    public function getStatus()
    {
        return $this->status;
    }

    public function getEstudante()
    {
        return $this->estudante;
    }

    public function getListaPresenca()
    {
        return $this->listaPresenca;
    }

    public function getDataUltimaAtualizacao()
    {
        return $this->dataUltimaAtualizacao;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setStatus($status)
    {
        $tiposStatusCheckin = array(STATUS_CHECKIN::AGUARDANDO_CONFIRMACAO, STATUS_CHECKIN::CONFIRMADO,
            STATUS_CHECKIN::EMBARCOU);

        if (!in_array($status, $tiposStatusCheckin))
        {
            throw new ValorEnumInvalidoException("STATUS_CHECKIN");
        }
        $this->status = $status;
    }

    public function setEstudante($estudante)
    {
        $this->estudante = $estudante;
    }

    public function setListaPresenca($listaPresenca)
    {
        $this->listaPresenca = $listaPresenca;
    }

    public function setDataUltimaAtualizacao($dataUltimaAtualizacao)
    {
        $this->dataUltimaAtualizacao = $dataUltimaAtualizacao;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'status' => $this->status,
            'dataUltimaAtualizacao' => $this->dataUltimaAtualizacao->format('d/m/Y H:i'),
            'estudante' => $this->estudante,
            'listaPresenca' => $this->listaPresenca->getId()
         );
    }
}
