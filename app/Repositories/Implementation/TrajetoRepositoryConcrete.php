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

    public function atualizarStatus($trajeto)
    {
        return $this->update($trajeto);
    }

    public function atualizar($trajeto)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();

        try
        {
            $this->removerPontosParada($entityManager, $trajeto);

            $this->adicionarPontosParada($entityManager, $trajeto, $trajeto->getPontosParada());

            $rota = $entityManager->find('\App\Entities\Rota', $trajeto->getRota()->getId());

            $trajeto->setRota($rota);

            $entityManager->merge($trajeto);
            $entityManager->flush();
//            $entityManager->refresh($trajeto);

            $trajetoSalvo = $entityManager->merge($trajeto);

            $entityManager->getConnection()->commit();

            return $trajetoSalvo;
        }
        catch (Exception $ex)
        {
            $entityManager->getConnection()->rollBack();

            throw $ex;
        }
        finally
        {
            $entityManager->close();
        }
    }

    private function adicionarPontosParada($entityManager, $trajeto, $pontosParada) // NOVOS TRAJETO E PONTOS
    {
        $trajetoBanco = $entityManager->find('\App\Entities\Trajeto', $trajeto->getId());

        foreach ($pontosParada as $pontoAtualizado)
        {
            $existe = false;

            foreach ($trajetoBanco->getPontosParada() as $velhoPonto)
            {
                if ($velhoPonto->getId() == $pontoAtualizado->getId())
                {
                    $existe = true;

                    break;
                }
            }
            if ($existe == false)
            {
                $entityManager->persist($pontoAtualizado);
            }
            else
            {
                $entityManager->merge($pontoAtualizado);
            }
        }
    }

    private function removerPontosParada($entityManager, $trajeto) // NOVO TRAJETO
    {
        $trajetoBanco = $entityManager->find('\App\Entities\Trajeto', $trajeto->getId());

        foreach ($trajetoBanco->getPontosParada() as $velhoPonto) // VELHOS PONTOS DE PARADA
        {
            $existe = false;

            foreach ($trajeto->getPontosParada() as $novoPonto)
            {
                if ($novoPonto->getId() == $velhoPonto->getId())
                {
                    $existe = true;

                    break;
                }
            }
            if ($existe == false) // SE NÃO EXISTIR NA LISTA
            {
                $trajetoBanco->getPontosParada()->removeElement($velhoPonto);

                $entityManager->remove($velhoPonto);
            }
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
