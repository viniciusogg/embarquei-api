<?php

namespace App\Entities;

use App\Entities\Usuario;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"admin" = "Administrador", "mot" = "Motorista"})
 */
abstract class Mensageiro extends Usuario 
{
    
}
