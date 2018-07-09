<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * @ORM\Entity
 * @ORM\Table(name="USER")
 */
class User implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use HasApiTokens, Notifiable, Authenticatable, Authorizable, CanResetPassword;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private $matricula;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $password;

    // ADICIONAR TIMESTAMP
        
    /**
     * id
     * @return String
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * name
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * name
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * matricula
     * @return String
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * matricula
     * @param String $matricula
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
    }

    /**
     * email
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * email
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * password
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * senha
     * @param String $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

}
