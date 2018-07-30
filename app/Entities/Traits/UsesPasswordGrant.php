<?php

namespace App\Entities\Traits;

use App\Entities\User;
use EntityManager;

trait UsesPasswordGrant
{
    /**
     * @param string $userIdentifier
     * @return User
     */
    public function findForPassport($userIdentifier)
    {        
        return EntityManager::getRepository('\App\Entities\User')->
                findOneBy(['matricula' => $userIdentifier]);
    }
}

