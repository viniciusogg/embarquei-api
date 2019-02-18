<?php

namespace App\Entities;

use App\Entities\Mensageiro;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="administradores") 
 **/
class Administrador extends Mensageiro 
{
    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OneToOne(targetEntity="Endereco", cascade={"all"}) 
     */
    protected $endereco;

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'numeroCelular' => $this->numeroCelular,
            'ativo' => $this->ativo,
            'beta' => $this->beta,
            'endereco' => $this->endereco->toArray()
        );
    }

}
