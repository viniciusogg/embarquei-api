<?php

namespace App\Repositories\Abstraction;

use Doctrine\ORM\EntityRepository;
use Exception;

abstract class Repository extends EntityRepository
{

    public function create($object) 
    {    
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
               
        try
        {
            $entityManager->persist($object);
            $entityManager->flush();
            $entityManager->getConnection()->commit();     
        } 
        catch (Exception $ex) 
        {
            $entityManager->getConnection()->rollback();    

            throw $ex;
        }
        finally
        {
            $entityManager->close();
        }
    }

    public function delete($id) 
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
               
        try
        {
            $object = $entityManager->find($this->getTypeObject(), $id);
            
            $entityManager->remove($object);
            $entityManager->flush();
            $entityManager->getConnection()->commit();     
        } 
        catch (Exception $ex) 
        {
            $entityManager->getConnection()->rollback();    
            
            throw $ex;
        }
        finally
        {
            $entityManager->close();
        }
    }

    public function getAll() 
    {        
        $entityManager = $this->getEntityManager();
        
        try
        {                                    
//            $query = $entityManager->
//                    createQuery('select t from ' . $this->getTypeObject() . ' t');   
//            
//            return $query->getResult();
            $result = $entityManager->getRepository($this->getTypeObject())->findAll();
            
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

    public function getById($id)
    {
        $entityManager = $this->getEntityManager();
        
        try
        {
            return $entityManager->find($this->getTypeObject(), $id);    
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

    public function update($object)
    {    
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
//        error_log($object);
//        print_r($object);
        
        try
        {
            $result = $entityManager->merge($object);
            
            $entityManager->flush();
            $entityManager->getConnection()->commit();     
    
            return $result;
        }
        catch (Exception $e)
        {
            $entityManager->getConnection()->rollback();
            
            throw $e;
        }
        finally
        {
            $entityManager->close();            
        }
    }

    protected abstract function getTypeObject();
}
