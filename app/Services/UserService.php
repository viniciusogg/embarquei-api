<?php

namespace App\Services;

use App\Repositories\Abstraction\UserRepositoryInterface;
use App\Repositories\Implementation\UserRepositoryConcrete;

use App\Entities\User;

class UserService 
{
	
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($data)
    {
        $user = new User();
        $user->setName($data['name']);
        $user->setMatricula($data['matricula']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        
        $this->userRepository->create($user);
        
        
    }

    public function findById()
    {

    }

    public function findAll()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
	
}
