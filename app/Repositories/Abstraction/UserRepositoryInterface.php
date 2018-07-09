<?php

namespace App\Repositories\Abstraction;

interface UserRepositoryInterface
{	
    public function getByMatricula($matricula);
	
    public function getByEmail($email);
    
}