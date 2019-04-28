<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\ListaPresencaRepositoryInterface;
use Exception;

class ListaPresencaRepositoryConcrete extends Repository implements ListaPresencaRepositoryInterface
{
    public function filtrarPorInstituicaoMotorista($idMotorista)
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $listasPresenca = [];

            $motorista = $entityManager->find('\App\Entities\Motorista', $idMotorista);

            foreach ($motorista->getInstituicoesEnsino() as $instituicao)
            {
                $query = $entityManager->createQuery(
                    'SELECT lp FROM \App\Entities\ListaPresenca lp '
                    . 'JOIN lp.instituicaoEnsino i '
                    . 'WHERE i.id = :instituicaoId'
                );
                $query->setParameters(['instituicaoId' => $instituicao->getId()]);

                $listaPresenca = $query->getOneOrNullResult();

                if (isset($listaPresenca))
                {
                    $listasPresenca[] = $listaPresenca->toArray();
                }
            }
            return $listasPresenca;
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

    public function filtrarPorInstituicaoRota($idInstituicao)
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $listasPresenca = [];

//            $ = $entityManager->find('\App\Entities\Motorista', $idMotorista);
            $query = $entityManager->createQuery(
                'SELECT r FROM \App\Entities\Rota r '
                . 'JOIN r.instituicoesEnsino ie '
                . 'WHERE ie.id = :instituicaoId'
            );
            $query->setParameters(['instituicaoId' => $idInstituicao]);

            $rota = $query->getOneOrNullResult();

            foreach ($rota->getInstituicoesEnsino() as $instituicao)
            {
                $query = $entityManager->createQuery(
                    'SELECT lp FROM \App\Entities\ListaPresenca lp '
                    . 'JOIN lp.instituicaoEnsino i '
                    . 'WHERE i.id = :instituicaoId'
                );
                $query->setParameters(['instituicaoId' => $instituicao->getId()]);

                $listaPresenca = $query->getOneOrNullResult();

                if (isset($listaPresenca))
                {
                    $listasPresenca[] = $listaPresenca->toArray();
                }
            }
            return $listasPresenca;
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
        return '\App\Entities\ListaPresenca';
    }
}
