<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\UserRepositoryInterface;
use App\Repositories\Abstraction\Repository;
use Exception;

class UserRepositoryConcrete extends Repository implements UserRepositoryInterface
{
    public function getByEmail($email) 
    {
        $entityManager = $this->getEntityManager();
        
        try
        {
            $result = $entityManager->getRepository($this->getTypeObject())->
                    findBy(['email' => $email]);
            
            return $result;        
        }
        catch (Exception $ex) 
        {
            throw $ex;            
        }
        finally
        {
            $entityManager->close();
        }
    }

    public function getByMatricula($matricula)
    {        
        $entityManager = $this->getEntityManager();
        
        try
        {
            $result = $entityManager->getRepository($this->getTypeObject())->
                    findBy(['matricula' => $matricula]);
        
            return $result;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
        finally
        {
            $entityManager->close();
        }
    }
    
    protected function getTypeObject() 
    {
        return '\App\Entities\User';
    }
}