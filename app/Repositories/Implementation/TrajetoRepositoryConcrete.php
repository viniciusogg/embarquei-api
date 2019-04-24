<?php

namespace App\Repositories\Implementation;

use App\Exceptions\NullFieldException;
use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\TrajetoRepositoryInterface;
use Exception;

class TrajetoRepositoryConcrete extends Repository implements TrajetoRepositoryInterface
{
    public function cadastrar($trajeto)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();

        try
        {
            $rota = $entityManager->merge($trajeto->getRota());

            $trajeto->setRota($rota);

            $entityManager->persist($trajeto);
            $entityManager->flush();
            $entityManager->getConnection()->commit();

            $entityManager->refresh($trajeto);

            $trajetoSalvo = $entityManager->merge($trajeto);

            return $trajetoSalvo;
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
        return '\App\Entities\Trajeto';
    }
    
    public function getTrajetosByCidadeInstituicaoRota($cidadeId, $instituicaoId)
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $query = $entityManager->createQuery(
                'SELECT t FROM App\Entities\Trajeto t '
                    . 'JOIN App\Entities\Rota r '
                    . 'JOIN r.trajetos rt '
                    . 'JOIN r.instituicoesEnsino i '
                    . 'JOIN r.cidade c '
                    . 'JOIN rt.rota tr '
                    . 'WHERE c.id = :cidadeId AND i.id = :instituicaoId' //AND tr.id = :rotaId'
            );
            
            $query->setParameters(array(
                'cidadeId' => $cidadeId,
                'instituicaoId' => $instituicaoId,
//                'rotaId' => $rotaId
            ));
                        
            return $query->getResult();
        }
        catch (Exception $ex) 
        {
            throw $ex;
        }
    }
}
