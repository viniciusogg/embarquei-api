<?php

namespace App\Entities;

use App\Entities\Traits\UsesPasswordGrant;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Passport\HasApiTokens;
use LaravelDoctrine\ORM\Auth\Authenticatable;
//use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use LaravelDoctrine\ORM\Notifications\Notifiable;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"est" = "Estudante", "mot"="Motorista", "usr"="Usuario", "admin"="Administrador"})
 */
class Usuario implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable, HasApiTokens, UsesPasswordGrant; // Timestamps,

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="string", nullable=false) */
    protected $nome;

    /** @ORM\Column(type="string", nullable=false) */
    protected $sobrenome;

    /** @ORM\Column(type="string", nullable=false, unique=true) */
    protected $numeroCelular;

    // SENHA ESTÁ NO TRAIT "Authenticatable"

    /** @ORM\Column(type="boolean", nullable=false) */
    protected $ativo;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
    }

    public function getNumeroCelular()
    {
        return $this->numeroCelular;
    }

    public function setNumeroCelular($numeroCelular)
    {
        $this->numeroCelular = $numeroCelular;
    }

    public function getSenha()
    {
        return $this->getPassword();
    }

    public function setSenha($senha)
    {
        $this->setPassword($senha);
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'numeroCelular' => $this->numeroCelular,
            'ativo' => $this->ativo
         );
    }

    // NECESSÁRIO PARA AUTENTICAÇÃO
    public function getKey()
    {
        return $this->getId();
    }
}
