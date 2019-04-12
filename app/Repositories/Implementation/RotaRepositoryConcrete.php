<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\RotaRepositoryInterface;
use App\Entities\Rota;
use App\Exceptions\NullFieldException;

class RotaRepositoryConcrete extends Repository implements RotaRepositoryInterface
{
    public function associarEPersistir($rota, $nomesInstituicoesEnsino, $idCidade)
    {
        $instituicoesEnsino = [];                
        
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        $repositoryInstituicaoEnsino = $entityManager->getRepository('\App\Entities\InstituicaoEnsino');
        $repositoryTrajeto = $entityManager->getRepository('\App\Entities\Trajeto');
        $repositoryCidade = $entityManager->getRepository('\App\Entities\Cidade');
        
        try
        {  
            foreach($nomesInstituicoesEnsino as $nomeInstituicao)
            {
                $instituicaoEnsino = $repositoryInstituicaoEnsino->findOneBy(['nome' => $nomeInstituicao['nome']]);

                if ($instituicaoEnsino) 
                {                
                    $instituicoesEnsino[] = $instituicaoEnsino;
                }
            }
            if (empty($instituicoesEnsino) || empty($rota->getTrajetos()))
            {
                throw new NullFieldException();
            }
            else
            {
                $rota->setInstituicoesEnsino($instituicoesEnsino);
            }
            $cidade = $repositoryCidade->findOneBy(['id' => $idCidade['id']]);
            
            if (empty($cidade))
            {
                throw new NullFieldException();
            }
            else
            {
                $rota->setCidade($cidade);
            }
            $entityManager->persist($rota);

            // TALVEZ ESSE FOR SEJA DESNECESSÁRIO
            foreach ($rota->getTrajetos() as $trajeto)
            {
                $repositoryTrajeto->getEntityManager()->persist($trajeto);
            }
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

    public function atualizar($rota, $instituicoesEnsino, $idCidade)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();

        $repositoryCidade = $entityManager->getRepository('\App\Entities\Cidade');

        try
        {
            $cidade = $repositoryCidade->findOneBy(['id' => $idCidade]);

            if (empty($cidade))
            {
                throw new NullFieldException();
            }
            else
            {
                $rota->setCidade($cidade);
            }
            $this->desassociarRotaInstituicoes($entityManager, $rota->getId(), $instituicoesEnsino);

            if (!empty($instituicoesEnsino))
            {
                $this->associarRotaInstituicoes($entityManager, $rota, $instituicoesEnsino);
            }
            $rotaAtualizada = $entityManager->merge($rota);

            $entityManager->flush();
            $entityManager->refresh($rotaAtualizada);
            $entityManager->getConnection()->commit();

            return $rotaAtualizada;
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

    private function associarRotaInstituicoes($entityManager, $rota, $instituicoes)
    {
        foreach($instituicoes as $instituicao)
        {
            $rota->getInstituicoesEnsino()->add($entityManager->getReference('\App\Entities\InstituicaoEnsino', $instituicao['id']));
            error_log(json_encode($rota->toArray()));
            $entityManager->merge($rota);
            $entityManager->flush();
        }
    }

    private function desassociarRotaInstituicoes($entityManager, $rotaId, $instituicoesEnsino)
    {
        $rota = $entityManager->find($this->getTypeObject(), $rotaId);

        foreach ($instituicoesEnsino as $instituicao)
        {
            $rota->getInstituicoesEnsino()->
                    removeElement($entityManager->getReference('\App\Entities\InstituicaoEnsino', $instituicao['id']));

            $entityManager->merge($rota);
            $entityManager->flush();
        }
    }

    public function getByCidade($cidadeId)
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $query = $entityManager->createQuery(
                'SELECT r FROM \App\Entities\Rota r '
                . 'JOIN r.cidade c '
                . 'WHERE c.id = :cidadeId'
            );
            $query->setParameters(['cidadeId' => $cidadeId]);

            $rota = $query->getResult();

            return $rota;
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

    public function getByInstituicaoCidade($instituicaoId, $cidadeId)
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $query = $entityManager->createQuery(
                'SELECT r FROM \App\Entities\Rota r '
                . 'JOIN r.cidade c '
                . 'JOIN r.instituicoesEnsino i '
                . 'WHERE c.id = :cidadeId AND i.id = :instituicaoId'
            );
            $query->setParameters(['instituicaoId' => $instituicaoId, 'cidadeId' => $cidadeId]);

            $rota = $query->getResult();

            return $rota;
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
        return '\App\Entities\Rota';
    }
}
