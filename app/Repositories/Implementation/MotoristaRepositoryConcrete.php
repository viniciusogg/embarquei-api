<?php

namespace App\Repositories\Implementation;

use App\Repositories\Implementation\UsuarioRepositoryConcrete;
use App\Repositories\Abstraction\MotoristaRepositoryInterface;
use App\Exceptions\NaoEncontradoException;
use Exception;

class MotoristaRepositoryConcrete extends UsuarioRepositoryConcrete implements MotoristaRepositoryInterface
{
    public function cadastrar($motorista, $instituicoesIds, $cidadeId)
    {
        $instituicoesEnsino = [];
        $motoristas = [];
        $motoristas[] = $motorista;
        
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();

        try
        {
            foreach($instituicoesIds as $instituicaoId)
            {                
                $instituicaoEnsino = $entityManager->find('\App\Entities\InstituicaoEnsino', $instituicaoId['id']);

                if ($instituicaoEnsino)
                {
                    $instituicaoEnsino->getMotoristas()->add($motorista);

                    $instituicoesEnsino[] = $instituicaoEnsino;

                    $entityManager->merge($instituicaoEnsino);
                }
            }
            if (empty($instituicoesEnsino))
            {
                throw new NaoEncontradoException();
            }
            $motorista->setInstituicoesEnsino($instituicoesEnsino);

            $cidade = $entityManager->find('App\Entities\Cidade', $cidadeId);

            $motorista->setCidade($cidade);

            $entityManager->persist($motorista);            
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

    public function atualizar()
    {

    }

    public function getByCidade($cidadeId)
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $query = $entityManager->createQuery(
                'SELECT m FROM \App\Entities\Motorista m '
                . 'JOIN m.cidade c '
                . 'WHERE c.id = :cidadeId'
            );
            $query->setParameter('cidadeId', $cidadeId);

            $motoristas = $query->getResult();

            return $motoristas;
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
        return '\App\Entities\Motorista';
    }
    
}
