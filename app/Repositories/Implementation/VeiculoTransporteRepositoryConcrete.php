<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\VeiculoTransporteRepositoryInterface;
use \Exception;

class VeiculoTransporteRepositoryConcrete extends Repository implements VeiculoTransporteRepositoryInterface
{
    public function cadastrar($veiculo, $instituicoesEnsino, $cidadeId)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();

        try
        {
            $cidade = $entityManager->find('\App\Entities\Cidade', $cidadeId);

            $veiculo->setCidade($cidade);

            $entityManager->persist($veiculo);

            foreach($instituicoesEnsino as $instituicao)
            {
                $instituicaoEnsino = $entityManager->find('\App\Entities\InstituicaoEnsino', $instituicao['id']);

                if ($instituicaoEnsino)
                {
                    $instituicaoEnsino->getVeiculosTransporte()->add($veiculo);

                    $veiculo->getInstituicoesEnsino()->add($instituicaoEnsino);

                    $entityManager->merge($instituicaoEnsino);
                    $entityManager->flush();
                }
            }
            $entityManager->merge($veiculo);
            $entityManager->flush();
            $entityManager->getConnection()->commit();
        }
        catch (Exception $ex)
        {
            $entityManager->getConnection()->rollBack();
            throw $ex;
        }
        finally
        {
            $entityManager->getConnection()->close();
            $entityManager->close();
        }
    }

    public function atualizar($veiculo, $instituicoesEnsino, $cidadeId)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();

        try
        {
            $cidadeBuscada = $entityManager->find('\App\Entities\Cidade', $cidadeId);

            $veiculo->setCidade($cidadeBuscada);

            $this->desassociarVeiculoInstituicoes($entityManager, $veiculo);

            if (!empty($instituicoesEnsino))
            {
                $this->associarVeiculoInstituicoes($entityManager, $veiculo, $instituicoesEnsino);
            }
            $veiculoAtualizado = $entityManager->merge($veiculo);

            $entityManager->flush();
            $entityManager->refresh($veiculoAtualizado);
            $entityManager->getConnection()->commit();

            return $veiculoAtualizado;
        }
        catch (Exception $ex)
        {
            $entityManager->getConnection()->rollback();

            throw $ex;
        }
        finally
        {
            $entityManager->getConnection()->close();
            $entityManager->close();
        }
    }

    private function desassociarVeiculoInstituicoes($entityManager, $veiculo)
    {
        $query = $entityManager->createQuery(
            'SELECT ie FROM \App\Entities\InstituicaoEnsino ie '
            . 'JOIN ie.veiculosTransporte v '
            . 'WHERE v.id = :veiculoId'
        );
        $query->setParameter('veiculoId', $veiculo->getId());

        $instituicoesEnsino = $query->getResult();

        foreach ($instituicoesEnsino as $instituicao)
        {
            $instituicao->getVeiculosTransporte()->
                    removeElement($entityManager->getReference($this->getTypeObject(), $veiculo->getId()));

            $entityManager->merge($instituicao);
            $entityManager->flush();
        }
    }

    private function associarVeiculoInstituicoes($entityManager, $veiculo, $instituicoesEnsino)
    {
        foreach($instituicoesEnsino as $instituicao)
        {
            $instituicaoBuscada = $entityManager->find('\App\Entities\InstituicaoEnsino', $instituicao['id']);

            if (isset($instituicaoBuscada))
            {
                $instituicaoBuscada->getVeiculosTransporte()->
                        add($entityManager->getReference($this->getTypeObject(), $veiculo->getId()));

                $entityManager->merge($instituicaoBuscada);
                $entityManager->flush();
            }
        }
    }

    public function getByCidade($cidadeId)
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $query = $entityManager->createQuery(
                'SELECT v FROM \App\Entities\VeiculoTransporte v '
                . 'JOIN v.cidade c '
                . 'WHERE c.id = :cidadeId'
            );
            $query->setParameter('cidadeId', $cidadeId);

            $veiculos = $query->getResult();

            return $veiculos;
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
                'SELECT v FROM \App\Entities\VeiculoTransporte v '
                . 'JOIN v.cidade c '
                . 'JOIN v.instituicoesEnsino i '
                . 'WHERE c.id = :cidadeId AND i.id = :instituicaoId'
            );
            $query->setParameters(['instituicaoId' => $instituicaoId, 'cidadeId' => $cidadeId]);

            $veiculos = $query->getOneOrNullResult();

            return $veiculos;
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

    protected function getTypeObject() {
        return '\App\Entities\VeiculoTransporte';
    }
}
