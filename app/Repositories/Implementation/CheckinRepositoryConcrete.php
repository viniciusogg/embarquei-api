<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\CheckinRepositoryInterface;
use App\Repositories\Abstraction\Repository;
use Exception;

class CheckinRepositoryConcrete extends Repository implements CheckinRepositoryInterface
{
    public function update($checkin)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();

        try
        {
            $query = $entityManager->createQuery(
                'SELECT c FROM \App\Entities\Checkin c '
                . 'WHERE c.id = :id'
            );
            $query->setParameter('id', $checkin->getId());

            $result = $query->getOneOrNullResult();

            $checkin->setEstudante($result->getEstudante());
            $checkin->setListaPresenca($result->getListaPresenca());

            $checkinAtualizado = $entityManager->merge($checkin);

            $entityManager->flush();
            $entityManager->getConnection()->commit();

            return $checkinAtualizado;
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

    public function getCheckiByIdEstudante($id)
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $query = $entityManager->createQuery(
              'SELECT c FROM \App\Entities\Checkin c '
                    . 'JOIN c.estudante e '
                    . 'WHERE e.id = :id'
            );
            $query->setParameter('id', $id);

            $checkin = $query->getOneOrNullResult();

            return $checkin;
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
        return '\App\Entities\Checkin';
    }
}