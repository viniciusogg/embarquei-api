<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\HorarioSemanalEstudanteRepositoryInterface;

class HorarioSemanalEstudanteRepositoryConcrete extends Repository implements HorarioSemanalEstudanteRepositoryInterface
{

    public function associarComEstudante() 
    {        
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        try
        {

            
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
    
    protected function getTypeObject() 
    {
        return '\App\Entities\HorarioSemanalEstudante';
    }
}
