<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\RotaRepositoryInterface;
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

    public function atualizar($rotaAtualizada, $instituicoesEnsino, $idCidade)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();

        try
        {
////            $rotaDesatualizada = $entityManager->find($this->getTypeObject(), $rotaAtualizada->getId());
//
////            $rotaDesatualizada->setNome($rotaAtualizada->getNome());
//
//            $rotaSemTrajetos = $this->desassociarRotaTrajetos($entityManager, $rotaAtualizada->getId());
//
////            $entityManager->clear('\App\Entities\Rota');
//
//            $rotaComTrajetos = $this->
//                    associarRotaTrajetos($entityManager, $rotaSemTrajetos->getId(), $rotaAtualizada->getTrajetos());
//
//            $trajetosSemPontos = [];
//
//            $entityManager->clear('\App\Entities\Trajeto');
//
//            foreach ($rotaComTrajetos->getTrajetos() as $trajetoDesatualizado)
//            {
//                $trajetoSemPonto = $this->desassociarTrajetoPontosParada($entityManager, $trajetoDesatualizado->getId());
//
//                $trajetosSemPontos[] = $trajetoSemPonto;
//
//                $entityManager->clear('\App\Entities\Trajeto');
//            }
//            $trajetosComPontos = [];
//
//            $cont = 0;
//
//            foreach ($trajetosSemPontos as $trajetoSemPonto)
//            {
//                $trajetoComPonto = $this->
//                        associarTrajetoPontosParada($entityManager, $trajetoSemPonto->getId(), $rotaAtualizada->getTrajetos()->get($cont));
//                $trajetosComPontos[] = $trajetoComPonto;
//
//                $cont++;
//            }
//            $rotaComTrajetos->setTrajetos($trajetosComPontos);
//
//            $this->desassociarRotaInstituicoes($entityManager, $rotaComTrajetos->getId());
//
//            $rotaComInstituicoes = $this->associarRotaInstituicoes($entityManager, $rotaComTrajetos, $instituicoesEnsino);
//
//            $cidade = $entityManager->find('\App\Entities\Cidade', $idCidade);
//
//            if (empty($cidade))
//            {
//                throw new NullFieldException();
//            }
//            else
//            {
//                $rotaComInstituicoes->setCidade($cidade);
//            }
//            $rotaComInstituicoes->setNome($rotaAtualizada->getNome());
//
//            $rotaFinal = $this->atualizarHorarioTrajetos($entityManager, $rotaComInstituicoes);
//
//            $entityManager->getConnection()->commit();
//
//            return $rotaFinal;
            $cidade = $entityManager->find('\App\Entities\Cidade', $idCidade);

            $rotaAtualizada->setCidade($cidade);

//            error_log(json_encode($rotaAtualizada->toArray(), JSON_PRETTY_PRINT));

            $entityManager->merge($rotaAtualizada);
//            $rotaComInstituicoes = $this->
//                    atualizarRotaInstituicoes($entityManager, $rotaAtualizada->getId(), $instituicoesEnsino);
//
//            $rotaComTrajetos = $this->
//                    atualizarRotaTrajetos($entityManager, $rotaComInstituicoes->getId(), $rotaAtualizada->getTrajetos());
//
//            foreach ($rotaAtualizada->getTrajetos() as $trajeto)
//            {
//                $this->atualizarTrajetoPontosParada($entityManager, $trajeto->getId(), $trajeto->getPontosParada());
//            }
            $rotaDesatualizada = $entityManager->find($this->getTypeObject(), $rotaAtualizada->getId());

            $entityManager->detach($rotaDesatualizada);

            $rotaDesatualizada->getTrajetos()->clear();

            foreach ($instituicoesEnsino as $instituicao)
            {
                $rotaDesatualizada->getInstituicoesEnsino()->add($instituicao);
            }
            $entityManager->merge($rotaDesatualizada);

            $entityManager->detach($rotaDesatualizada);

            $rotaDesatualizada->getTrajetos()->clear();

            foreach ($rotaAtualizada->getTrajetos() as $trajeto)
            {
                $rotaDesatualizada->getTrajetos()->add($trajeto);

                $trajeto->setRota($rotaDesatualizada);

                $entityManager->merge($trajeto);
            }
            // ------------ ATUALIZANDO PONTOS DE PARADA
            foreach ($rotaAtualizada->getTrajetos() as $trajeto)
            {
                $trajetoDesatualizado = $entityManager->find('\App\Entities\Trajeto', $trajeto->getId());

                $entityManager->detach($trajetoDesatualizado);

                $trajetoDesatualizado->getPontosParada()->clear();

                foreach ($trajeto->getPontosParada() as $ponto)
                {
                    $trajetoDesatualizado->getPontosParada()->add($ponto);

                    $ponto->setTrajeto($trajetoDesatualizado);

                    $entityManager->merge($ponto);
                }
            }
            $rotaFinal = $entityManager->find($this->getTypeObject(), $rotaDesatualizada->getId());

            $entityManager->flush();

            $entityManager->getConnection()->commit();

            return $rotaFinal;
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






    private function atualizarRotaInstituicoes($entityManager, $rotaId, $instituicoes)
    {
        $rota = $entityManager->find($this->getTypeObject(), $rotaId);

        $entityManager->detach($rota);

        $rota->getTrajetos()->clear();

        foreach ($instituicoes as $instituicao)
        {
            $rota->getInstituicoesEnsino()->add($instituicao);
        }
        $entityManager->merge($rota);
        $entityManager->flush();

        return $rota;
    }

    private function atualizarRotaTrajetos($entityManager, $rotaId, $trajetos)
    {
        $rota = $entityManager->find($this->getTypeObject(), $rotaId);

        $entityManager->detach($rota);

        $rota->getTrajetos()->clear();

        foreach ($trajetos as $trajeto)
        {
            $rota->getTrajetos()->add($trajeto);

            $trajeto->setRota($rota);

            $entityManager->merge($trajeto->getHorarioTrajeto());
            $entityManager->merge($trajeto);
        }
        $entityManager->flush();

        return $rota;
    }

    private function atualizarTrajetoPontosParada($entityManager, $trajetoId, $pontosParada)
    {
        $trajeto = $entityManager->find('\App\Entities\Trajeto', $trajetoId);

        $entityManager->detach($trajeto);

        $trajeto->getPontosParada()->clear();

        foreach ($pontosParada as $ponto)
        {
            $trajeto->getPontos()->add($ponto);

            $ponto->setTrajeto($trajeto);

            $entityManager->merge($ponto);
        }
        $entityManager->flush();

        return $trajeto;
    }






    private function associarRotaInstituicoes($entityManager, $rota, $instituicoes)
    {
        $trajetos = [];

        foreach ($instituicoes as $instituicao)
        {
            $rota->getInstituicoesEnsino()->
                    add($entityManager->getReference('\App\Entities\InstituicaoEnsino', $instituicao['id']));
        }
        foreach ($rota->getTrajetos() as $trajeto)
        {
            $trajeto->setRota($rota);

            $trajetos[] = $entityManager->merge($trajeto);

            $entityManager->flush();
        }
        $rota->setTrajetos($trajetos);

        return $rota;
    }

    private function desassociarRotaInstituicoes($entityManager, $rotaId)
    {
        $rota = $entityManager->find($this->getTypeObject(), $rotaId);

        foreach ($rota->getInstituicoesEnsino() as $instituicao)
        {
            $rota->getInstituicoesEnsino()->
                    removeElement($entityManager->getReference('\App\Entities\InstituicaoEnsino', $instituicao->getId()));
        }
        foreach ($rota->getTrajetos() as $trajeto)
        {
            $trajeto->setRota($rota);

            $trajetos[] = $entityManager->merge($trajeto);

            $entityManager->flush();
        }
        $rota->setTrajetos($trajetos);

        return $rota;
    }

    private function associarRotaTrajetos($entityManager, $rotaId, $trajetos)
    {
        $rota = $entityManager->find($this->getTypeObject(), $rotaId);

        foreach ($trajetos as $trajeto)
        {
            $rota->getTrajetos()->add($trajeto);

//            $entityManager->persist($trajeto);
        }
        foreach ($trajetos as $trajeto)
        {
            $trajeto->setRota($rota);

            $entityManager->merge($trajeto);
        }
        $entityManager->flush();

        return $rota;
    }

    private function desassociarRotaTrajetos($entityManager, $rotaId)
    {
        $rota = $entityManager->find($this->getTypeObject(), $rotaId);

        foreach ($rota->getTrajetos() as $trajeto)
        {
            $entityManager->remove($trajeto);
            $entityManager->flush();

            $rota->getTrajetos()->removeElement($trajeto, $trajeto->getId());
        }
        return $rota;
    }

    private function associarTrajetoPontosParada($entityManager, $trajetoDesatualizadoId, $trajetoAtualizado)
    {
        $trajetoDesatualizado = $entityManager->find('\App\Entities\Trajeto', $trajetoDesatualizadoId);

        foreach ($trajetoAtualizado->getPontosParada() as $pontoParada)
        {
            $trajetoDesatualizado->getPontosParada()->add($pontoParada);

            $pontoParada->setTrajeto($trajetoDesatualizado);

            $entityManager->merge($pontoParada);
            $entityManager->flush();
        }
        return $trajetoDesatualizado;
    }

    private function desassociarTrajetoPontosParada($entityManager, $trajetoId)
    {
        $trajeto = $entityManager->find('\App\Entities\Trajeto', $trajetoId);

        foreach ($trajeto->getPontosParada() as $pontoParada)
        {
            $entityManager->remove($pontoParada);
            $entityManager->flush();

            $trajeto->getPontosParada()->removeElement($pontoParada, $pontoParada->getId());
        }
        return $trajeto;
    }

    private function atualizarHorarioTrajetos($entityManager, $rota)
    {
        foreach($rota->getTrajetos() as $trajeto)
        {
            $horarioAtualizado = $entityManager->merge($trajeto->getHorarioTrajeto());

            $trajeto->setHorarioTrajeto($horarioAtualizado);

            $entityManager->flush();
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
