<?php

namespace App\Repositories\Implementation;

use App\Repositories\Implementation\UsuarioRepositoryConcrete;
use App\Repositories\Abstraction\MotoristaRepositoryInterface;
use App\Exceptions\NaoEncontradoException;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class MotoristaRepositoryConcrete extends UsuarioRepositoryConcrete implements MotoristaRepositoryInterface
{
    public function cadastrar($motorista, $instituicoesIds, $cidadeId)
    {
        $instituicoesEnsino = [];
//        $motoristas = [];
//        $motoristas[] = $motorista;
        
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

    public function atualizar($motorista, $instituicoesIds, $cidadeId)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();

        try
        {
            $cidadeBuscada = $entityManager->find('\App\Entities\Cidade', $cidadeId);

            $motorista->setCidade($cidadeBuscada);

            if ($motorista->getSenha() === null)
            {
                $senha = $entityManager->find($this->getTypeObject(), $motorista->getId())->getSenha();
                $motorista->setSenha($senha);
            }
            $this->desassociarMotoristaInstituicoes($entityManager, $motorista);

            if (!empty($instituicoesIds))
            {
                $this->associarMotoristaInstituicoes($entityManager, $motorista, $instituicoesIds);
            }
            $motoristaAtualizado = $entityManager->merge($motorista);
            $entityManager->flush();
            $entityManager->refresh($motoristaAtualizado);

            $entityManager->getConnection()->commit();

            return $motoristaAtualizado;
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

    private function desassociarMotoristaInstituicoes($entityManager, $motorista)
    {
        $query = $entityManager->createQuery(
            'SELECT ie FROM \App\Entities\InstituicaoEnsino ie '
            . 'JOIN ie.motoristas m '
            . 'WHERE m.id = :motoristaId'
        );
        $query->setParameter('motoristaId', $motorista->getId());

        $instituicoesEnsino = $query->getResult();

        foreach ($instituicoesEnsino as $instituicao)
        {
            $instituicao->getMotoristas()->
                    removeElement($entityManager->getReference($this->getTypeObject(), $motorista->getId()));

            $entityManager->merge($instituicao);
            $entityManager->flush();
        }
    }

    private function associarMotoristaInstituicoes($entityManager, $motorista, $instituicoesIds)
    {
        foreach($instituicoesIds as $instituicao)
        {
            $instituicaoBuscada = $entityManager->find('\App\Entities\InstituicaoEnsino', $instituicao['id']);

            if (isset($instituicaoBuscada))
            {
                $instituicaoBuscada->getMotoristas()->
                        add($entityManager->getReference($this->getTypeObject(), $motorista->getId()));

                $entityManager->merge($instituicaoBuscada);
                $entityManager->flush();
            }
        }
    }

    public function getByInstituicaoCidade($instituicaoId, $cidadeId)
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $query = $entityManager->createQuery(
                'SELECT m FROM \App\Entities\Motorista m '
                . 'JOIN m.cidade c '
                . 'JOIN m.instituicoesEnsino i '
                . 'WHERE c.id = :cidadeId AND i.id = :instituicaoId'
            );
            $query->setParameters(['instituicaoId' => $instituicaoId, 'cidadeId' => $cidadeId]);

            $motorista = $query->getOneOrNullResult();

            return $motorista;
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
