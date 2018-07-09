<?php

namespace App\Repositories\Implementation;

use App\Repositories\Implementation;
use App\Repositories\Abstraction\UserRepositoryInterface;

class UserRepositoryConcrete extends RepositoryConcrete implements UserRepositoryInterface
{

    public function getByEmail($email) {
            $this->findBy(['email' => $email]);
    }

    public function getByMatricula($matricula) {
            $this->findBy(['matricula' => $matricula]);
    }
}