<?php

namespace App\Entities;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User implements
	AuthenticatableContract,
	AuthorizableContract,
	CanResetPasswordContract // extends Authenticatable
{
	use HasApiTokens, Notifiable, Authenticatable, Authorizable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = [
    //    'name', 'email', 'password',
    //];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    //protected $hidden = [
    //    'password', 'remember_token',
    //];
	
	/**
	 *
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
	 */
	private $id;
	
	/**
	 *
	 * @ORM\Column(type="string", nullable=false)
	 */
	private $nome;
	
	private $matricula;
	
	private $email;
	
	private $senha;

    /**
     * id
     * @return Long
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * id
     * @param Long $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * nome
     * @return String
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * nome
     * @param String $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
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
     * senha
     * @return String
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * senha
     * @param String $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

}
