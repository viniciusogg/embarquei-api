<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\RotaRepositoryInterface;
use App\Exceptions\NullFieldException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\ResultSetMapping;
use Exception;

class RotaRepositoryConcrete extends Repository implements RotaRepositoryInterface
{
    public function associarEPersistir($rota, $instituicoesEnsino, $idCidade)
    {
        $instituicoesEnsino = [];
        
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
//        $repositoryInstituicaoEnsino = $entityManager->getRepository('\App\Entities\InstituicaoEnsino');
        $repositoryTrajeto = $entityManager->getRepository('\App\Entities\Trajeto');
//        $repositoryCidade = $entityManager->getRepository('\App\Entities\Cidade');
        
        try
        {  
//            foreach($instituicoesEnsino as $instituicao)
//            {
//                $instituicaoEnsino = $entityManager->find('\App\Entities\InstituicaoEnsino', $instituicao['id']);
//
//                if ($instituicaoEnsino)
//                {
//                    $instituicoesEnsino[] = $instituicaoEnsino;
//                }
//            }
//            if (empty($instituicoesEnsino) || empty($rota->getTrajetos()))
//            {
//                throw new NullFieldException();
//            }
//            else
//            {
//                $rota->setInstituicoesEnsino($instituicoesEnsino);
//            }
            $rota = $this->associarRotaInstituicoes($rota, $instituicoesEnsino);

            $cidade = $entityManager->find('\App\Entities\Cidade', $idCidade);
            
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
//            foreach ($rota->getTrajetos() as $trajeto)
//            {
//                $repositoryTrajeto->getEntityManager()->persist($trajeto);
//            }
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

        try
        {
            $rotaNoBanco = $entityManager->find($this->getTypeObject(), $rota->getId());

            $rotaSemInstituicoes = $this->desassociarRotaInstituicoes($entityManager, $rotaNoBanco);

            $this->associarRotaInstituicoes($entityManager, $rotaSemInstituicoes, $instituicoesEnsino);

            foreach ($rotaNoBanco->getTrajetos() as $trajetoNoBanco)
            {
               $this->removerPontosParada($entityManager, $trajetoNoBanco);
            }
            foreach ($rota->getTrajetos() as $trajeto)
            {
                $this->adicionarPontosParada($entityManager, $trajeto, $trajeto->getPontosParada());
            }
            $cidade = $entityManager->find('\App\Entities\Cidade', $idCidade);

            if (empty($cidade))
            {
                throw new NullFieldException();
            }
            else
            {
                $rota->setCidade($cidade);
            }
            $entityManager->merge($rota);
            $entityManager->flush();
            $entityManager->clear('\App\Entities\Rota');
            $entityManager->getConnection()->commit();

            return $entityManager->find($this->getTypeObject(), $rota->getId());
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

    private function adicionarPontosParada($entityManager, $trajeto, $pontosParada)
    {
        foreach ($pontosParada as $pontoParada)
        {
            $trajeto->getPontosParada()->add($pontoParada);

            $pontoParada->setTrajeto($trajeto);

            $entityManager->persist($pontoParada);
        }
        return $trajeto;
    }

    private function removerPontosParada($entityManager, $trajeto)
    {
        foreach ($trajeto->getPontosParada() as $pontoParada)
        {
            $trajeto->getPontosParada()->removeElement($pontoParada);

            $entityManager->remove($pontoParada);
        }
    }

    private function desassociarRotaInstituicoes($entityManager, $rota)
    {
        $sql = '
            SELECT ie.id ' .
                'FROM instituicoes_ensino ie ' .
            'WHERE ie.id IN ' .
                '(SELECT ir.instituicao_ensino_id ' .
                    'FROM instituicao_ensino_rota ir ' .
                'WHERE ir.rota_id = ?)';

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('\App\Entities\InstituicaoEnsino', 'ie');
        $rsm->addFieldResult('ie', 'id', 'id');

        $query = $entityManager->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $rota->getId());

        $idsInstituicoesEncontradas = $query->getResult();
        $instituicoesEnsino = [];

        foreach ($idsInstituicoesEncontradas as $idInstituicao)
        {
            $instituicoesEnsino[] = $entityManager->find('\App\Entities\InstituicaoEnsino', $idInstituicao);
        }
        foreach ($instituicoesEnsino as $instituicao)
        {
            $rota->getInstituicoesEnsino()->removeElement($instituicao);

            $entityManager->merge($rota);
        }
        return $rota;
    }

    private function associarRotaInstituicoes($entityManager, $rota, $instituicoesEnsino)
    {
        $idRota = $rota->getId();

        foreach($instituicoesEnsino as $instituicao)
        {
            $instituicaoBuscada = $entityManager->find('\App\Entities\InstituicaoEnsino', $instituicao['id']);

            $rota->getInstituicoesEnsino()->add($instituicaoBuscada);

//            $entityManager->merge($instituicaoBuscada);
            if (isset($idRota))
            {
                $entityManager->merge($rota);
            }
        }
        return $rota;
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
