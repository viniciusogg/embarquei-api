<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="listas_presenca")
 */
class ListaPresenca 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** 
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OneToMany(targetEntity="Checkin", mappedBy="listaPresenca", cascade={"remove"}, fetch="EAGER") 
     */
    protected $checkins;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="InstituicaoEnsino", inversedBy="listasPresenca", fetch="EAGER") 
     */
    protected $instituicaoEnsino;

    public function __construct()
    {
        $this->checkins =  new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCheckins()
    {
        return $this->checkins;
    }

    public function getInstituicaoEnsino()
    {
        return $this->instituicaoEnsino;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCheckins($checkins)
    {
        $this->checkins = $checkins;
    }

    public function setInstituicaoEnsino($instituicaoEnsino)
    {
        $this->instituicaoEnsino = $instituicaoEnsino;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'checkins' => $this->checkins,
            'instituicaoEnsino' => $this->instituicaoEnsino
         );
    }
}
