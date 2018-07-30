<?php

namespace App\Entities;

use App\Entities\Traits\UsesPasswordGrant;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Passport\HasApiTokens;
use LaravelDoctrine\ORM\Auth\Authenticatable;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use LaravelDoctrine\ORM\Notifications\Notifiable;

/*
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
*/

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class User implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Timestamps, Notifiable, HasApiTokens, UsesPasswordGrant;

    /*public function __construct($name, $matricula, $email, $password)
    {
        $this->setName($name);
        $this->setMatricula($matricula);
        $this->setEmail($email);
        $this->setPassword($password);
    }*/

    public function __construct()
    {
        //
    }


    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    protected $matricula;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $password;

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
     * id
     * @param String $id
     */
    public function setId($id)
    {
        $this->id = $id;
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

    public function toArray()
    {
        return array('id' => $this->id, 'name' => $this->name, 
            'matricula' => $this->matricula, 'email' => $this->email);
    }
    
    public function getKey() 
    {
        return $this->getId();
    }
}
