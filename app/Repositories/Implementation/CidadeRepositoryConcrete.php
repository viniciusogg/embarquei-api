<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\CidadeRepositoryInterface;

class CidadeRepositoryConcrete extends Repository implements CidadeRepositoryInterface
{

    protected function getTypeObject() 
    {
        return '\App\Entities\Cidade';
    }
    
    public function getByNome($nome) 
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $result = $entityManager->getRepository($this->getTypeObject())->
                    findOneBy(['nome' => $nome]);

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
}
