<?php

namespace App\Entities\Traits;

use App\Entities\Usuario;
use EntityManager;

trait UsesPasswordGrant
{
    /**
     * @param string $userIdentifier
     * @return Usuario
     */
    public function findForPassport($userIdentifier)
    {
        return EntityManager::getRepository('\App\Entities\Usuario')->
                findOneBy(['numeroCelular' => $userIdentifier]);
    }
}

