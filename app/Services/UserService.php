<?php

namespace App\Services;

use App\Repositories\Abstraction\UserRepositoryInterface;
use App\Repositories\Implementation\UserRepositoryConcrete;
use App\Entities\User;
use Illuminate\Support\Facades\Hash;

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

        /*
         * 
         $data['name'], $data['matricula'], 
         $data['email'], Hash::make($data['password'])   
         */
        
        $user->setName($data['name']);
        $user->setMatricula($data['matricula']);
        $user->setEmail($data['email']);
        $user->setPassword(Hash::make($data['password']));
        
        $this->userRepository->create($user);
    }

    public function findById($id)
    {        
        return $this->userRepository->getById($id);        
    }
    
    public function findByMatricula($matricula)
    {
        return $this->userRepository->getByMatricula($matricula);
    }

    public function findAll()
    {
        $result = $this->userRepository->getAll();
        
        $users = array();

        foreach ($result as $user) {
            $users[] = $user->toArray();
        }
        
        return $users;
    }

    public function update($data, $id)
    {  
        $password = $data['password'];
        
        if (Hash::needsRehash($data['password']))
        {
            $password = Hash::make($data['password']);
        }
        
        $user = new User($data['name'], $data['matricula'], 
                $data['email'], $password);
        $user->setId($id);

        return  $this->userRepository->update($user);
    }

    public function delete($id)
    {        
        $this->userRepository->delete($id);
    }
    
}
