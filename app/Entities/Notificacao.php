<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Entities\Enums\TIPO_NOTIFICACAO as TIPO_NOTIFICACAO;
use App\Exceptions\ValorEnumInvalidoException;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="notificacoes")
 */
class Notificacao 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;
    
    /** @ORM\Column(type="string", nullable=false) */    
    protected $titulo;
    
    /** @ORM\Column(type="string", nullable=false) */
    protected $descricao;
    
    /** @ORM\Column(type="string", nullable=false) */
    protected $tipo;
    
    /** @ORM\Column(type="datetime", nullable=false) */    
    protected $dataEnvio;
    
    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Mensageiro", fetch="EAGER") 
     */
    protected $remetente;
    
    public function getId() 
    {
        return $this->id;
    }

    public function getTitulo() 
    {
        return $this->titulo;
    }

    public function getDescricao() 
    {
        return $this->descricao;
    }

    public function getTipo() 
    {
        return $this->tipo;
    }

    public function getDataEnvio() 
    {
        return $this->dataEnvio;
    }

    public function getRemetente() 
    {
        return $this->remetente;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function setTitulo($titulo) 
    {
        $this->titulo = $titulo;
    }

    public function setDescricao($descricao) 
    {
        $this->descricao = $descricao;
    }

    public function setTipo($tipo) 
    {
        $tiposNotificacoes = array(TIPO_NOTIFICACAO::ATRASO_TRANSPORTE, TIPO_NOTIFICACAO::AUSENCIA_TRANSPORTE,
            TIPO_NOTIFICACAO::CONFIRMACAO_PRESENCA, TIPO_NOTIFICACAO::MUDANCA_MOTORISTA, TIPO_NOTIFICACAO::MUDANCA_ROTA,
            TIPO_NOTIFICACAO::MUDANCA_VEICULO, TIPO_NOTIFICACAO::RENOVACAO_CADASTRO);

        if (!in_array($tipo, $tiposNotificacoes))
        {
            throw new ValorEnumInvalidoException("TIPO_NOTIFICACAO");
        }
        $this->tipo = $tipo;
    }

    public function setDataEnvio($dataEnvio) 
    {
        $this->dataEnvio = $dataEnvio;
    }

    public function setRemetente($remetente) 
    {
        $this->remetente = $remetente;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'tipo' => $this->tipo,
            'dataEnvio' => $this->dataEnvio,
            'remetente' => $this->remetente
         );
    }
}
