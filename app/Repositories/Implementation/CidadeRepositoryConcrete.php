<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\CidadeRepositoryInterface;

class CidadeRepositoryConcrete extends Repository implements CidadeRepositoryInterface
{  
    public function buscarCidadesComRotas()
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $query = $entityManager->createQuery(
                'SELECT c FROM \App\Entities\Cidade c '
                    . 'JOIN \App\Entities\Rota r '
                    . 'JOIN r.cidade rc '
                    . 'WHERE rc.id = c.id'
            );
            $cidades = $query->getResult();            

            return $cidades;
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
    
    protected function getTypeObject() 
    {
        return '\App\Entities\Cidade';
    }
}
