<?php

namespace App\Repositories\Implementation;

use Doctrine\ORM\EntityRepository;

abstract class RepositoryConcrete extends EntityRepository
{

    public function create($object) 
    {    
        $entityManager = $this->getEntityManager();
        $entityManager->beginTransaction();
               
        try
        {
            $entityManager->persist($object);
            $entityManager->commit();        
        } 
        catch (Exception $ex) 
        {
            error_log($ex);
            $entityManager->rollback();            
        }
        finally
        {
            $entityManager->flush();
            $entityManager->close();
        }
    }

    public function delete($id) 
    {
        
    }

    public function getAll() 
    {               
        try
        {

        } 
        catch (Exception $ex) 
        {

        }
        finally
        {

        }
    }

    public function getById($id)
    {
        
    }

    public function update($object)
    {
        
    }

}
