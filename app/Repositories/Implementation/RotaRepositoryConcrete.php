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

//    public function atualizar($rotaAtualizada, $instituicoesEnsino, $idCidade)
//    {
//        $entityManager = $this->getEntityManager();
//        $entityManager->getConnection()->beginTransaction();
//
//        try
//        {
//////            $rotaDesatualizada = $entityManager->find($this->getTypeObject(), $rotaAtualizada->getId());
////
//////            $rotaDesatualizada->setNome($rotaAtualizada->getNome());
////
////            $rotaSemTrajetos = $this->desassociarRotaTrajetos($entityManager, $rotaAtualizada->getId());
////
//////            $entityManager->clear('\App\Entities\Rota');
////
////            $rotaComTrajetos = $this->
////                    associarRotaTrajetos($entityManager, $rotaSemTrajetos->getId(), $rotaAtualizada->getTrajetos());
////
////            $trajetosSemPontos = [];
////
////            $entityManager->clear('\App\Entities\Trajeto');
////
////            foreach ($rotaComTrajetos->getTrajetos() as $trajetoDesatualizado)
////            {
////                $trajetoSemPonto = $this->desassociarTrajetoPontosParada($entityManager, $trajetoDesatualizado->getId());
////
////                $trajetosSemPontos[] = $trajetoSemPonto;
////
////                $entityManager->clear('\App\Entities\Trajeto');
////            }
////            $trajetosComPontos = [];
////
////            $cont = 0;
////
////            foreach ($trajetosSemPontos as $trajetoSemPonto)
////            {
////                $trajetoComPonto = $this->
////                        associarTrajetoPontosParada($entityManager, $trajetoSemPonto->getId(), $rotaAtualizada->getTrajetos()->get($cont));
////                $trajetosComPontos[] = $trajetoComPonto;
////
////                $cont++;
////            }
////            $rotaComTrajetos->setTrajetos($trajetosComPontos);
////
////            $this->desassociarRotaInstituicoes($entityManager, $rotaComTrajetos->getId());
////
////            $rotaComInstituicoes = $this->associarRotaInstituicoes($entityManager, $rotaComTrajetos, $instituicoesEnsino);
////
////            $cidade = $entityManager->find('\App\Entities\Cidade', $idCidade);
////
////            if (empty($cidade))
////            {
////                throw new NullFieldException();
////            }
////            else
////            {
////                $rotaComInstituicoes->setCidade($cidade);
////            }
////            $rotaComInstituicoes->setNome($rotaAtualizada->getNome());
////
////            $rotaFinal = $this->atualizarHorarioTrajetos($entityManager, $rotaComInstituicoes);
////
////            $entityManager->getConnection()->commit();
////
////            return $rotaFinal;
//            $cidade = $entityManager->find('\App\Entities\Cidade', $idCidade);
//
//            $rotaAtualizada->setCidade($cidade);
//
//            $entityManager->merge($rotaAtualizada);
//
////            $rotaDesatualizada = $entityManager->find($this->getTypeObject(), $rotaAtualizada->getId());
////
////            $entityManager->detach($rotaDesatualizada);
////
////            $rotaDesatualizada->getTrajetos()->clear();
////
////            foreach ($instituicoesEnsino as $instituicao)
////            {
////                $rotaDesatualizada->getInstituicoesEnsino()->add($instituicao);
////            }
////            $entityManager->merge($rotaDesatualizada);
////
////            $entityManager->detach($rotaDesatualizada);
////
////            $rotaDesatualizada->getTrajetos()->clear();
////
////            foreach ($rotaAtualizada->getTrajetos() as $trajeto)
////            {
////                $rotaDesatualizada->getTrajetos()->add($trajeto);
////
////                $trajeto->setRota($rotaDesatualizada);
////
////                $entityManager->merge($trajeto);
////            }
//              // -------------------------------------------------------------------- ATUALIZANDO PONTOS DE PARADA
////            foreach ($rotaAtualizada->getTrajetos() as $trajeto)
////            {
////                $trajetoDesatualizado = $entityManager->find('\App\Entities\Trajeto', $trajeto->getId());
////
////                  // -------------------------------------------------------------------------------------------
////                $pontosRemovidos = new ArrayCollection($trajetoDesatualizado->getPontosParada()->toArray());
////
////                foreach ($trajeto->getPontosParada() as $novoPonto)
////                {
////                    $pontosRemovidos->removeElement($novoPonto);
////                }
////                foreach ($pontosRemovidos as $pontoRemovido)
////                {
////                    $trajetoDesatualizado->getPontosParada()->removeElement($pontoRemovido);
////
////                    $pontoRemovido->setTrajeto(null);
////                }
////                $novosPontos = new ArrayCollection($trajeto->getPontosParada()->toArray());
////
////                foreach ($trajetoDesatualizado->getPontosParada() as $pontoDesatualizado)
////                {
////                    $novosPontos->removeElement($pontoDesatualizado);
////                }
////                foreach ($novosPontos as $novoPonto)
////                {
////                    $trajeto->getPontosParada()->removeElement($novoPonto);
////                }
////                foreach ($trajeto->getPontosParada() as $ponto)
////                {
////                    $ponto->setTrajeto($trajetoDesatualizado);
////
////                    $pontoAtualizado = $entityManager->merge($ponto);
////
////                    $trajetoDesatualizado->
////                            getPontosParada()->
////                            set($trajetoDesatualizado->getPontosParada()->indexOf($pontoAtualizado), $pontoAtualizado);
////                }
////                foreach ($novosPontos as $novoPonto)
////                {
////                    $trajetoDesatualizado->getPontosParada()->add($novoPonto);
////
////                    $novoPonto->setTrajeto($trajetoDesatualizado);
////                }
//                // --------------------------------------------------------------------------------------------
////                $entityManager->detach($trajetoDesatualizado);
////
////                $trajetoDesatualizado->getPontosParada()->clear();
////
////                foreach ($trajeto->getPontosParada() as $ponto)
////                {
////                    $trajetoDesatualizado->getPontosParada()->add($ponto);
////                }
////                $entityManager->merge($trajetoDesatualizado);
////            }
//            $entityManager->flush();
//
//            $rotaFinal = $entityManager->find($this->getTypeObject(), $rotaAtualizada->getId());
//
//            $entityManager->getConnection()->commit();
//
//            return $rotaFinal;
//        }
//        catch (Exception $ex)
//        {
//            $entityManager->getConnection()->rollback();
//
//            throw $ex;
//        }
//        finally
//        {
//            $entityManager->close();
//        }
//    }

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
        foreach($instituicoesEnsino as $instituicao)
        {
            $instituicaoBuscada = $entityManager->find('\App\Entities\InstituicaoEnsino', $instituicao['id']);

            $rota->getInstituicoesEnsino()->add($instituicaoBuscada);

            $entityManager->merge($instituicaoBuscada);
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
