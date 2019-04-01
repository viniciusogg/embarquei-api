<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="geolocalizacoes")
 */
class Geolocalizacao
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="decimal", nullable=false, precision=10, scale=8) */
    protected $lat;

    /** @ORM\Column(type="decimal", nullable=false, precision=11, scale=8) */
    protected $lng;

    public function __construct() {}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function setLat($lat): void
    {
        $this->lat = $lat;
    }

    public function getLng()
    {
        return $this->lng;
    }

    public function setLng($lng): void
    {
        $this->lng = $lng;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'lat' => $this->lat,
            'lng' => $this->lng,
        );
    }
}