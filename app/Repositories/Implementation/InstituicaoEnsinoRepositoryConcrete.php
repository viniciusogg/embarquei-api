<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\InstituicaoEnsinoRepositoryInterface;
use App\Repositories\Abstraction\Repository;
use App\Exceptions\NaoEncontradoException;
use Doctrine\ORM\Query\ResultSetMapping;
use Exception;

class InstituicaoEnsinoRepositoryConcrete extends Repository implements InstituicaoEnsinoRepositoryInterface 
{
    public function getByNome($nome) 
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $result = $entityManager->getRepository($this->getTypeObject())->
                    findOneBy(['nome' => $nome]);

            return $result;
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
    
    public function cadastrar($instituicaoEnsino, $nomeCidade)
    {        
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        $cidadeRepository = $this->getEntityManager()->getRepository('\App\Entities\Cidade');
        
        try
        {            
            $cidade = $cidadeRepository->findOneBy(['nome' => $nomeCidade]);
            
            if(!$cidade)
            {
                throw new NaoEncontradoException();
            }
            $instituicaoEnsino->getEndereco()->setCidade($cidade);
            
            $cidade->getEnderecos()->add($instituicaoEnsino->getEndereco());
            
            // ATUALIZANDO CIDADE COM NOVO ENDEREÇO
            $cidadeRepository->getEntityManager()->merge($cidade); 
            
            $entityManager->persist($instituicaoEnsino);
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

    public function buscarInstituicoesSemMotorista($cidadeId)
    {
        $entityManager = $this->getEntityManager();

        try
        { // CONSULTA DEVE RETORNAR INSTITUIÇÕES QUE NÃO TENHAM MOTORISTA ASSOCIADO AO MUNICÍPIO PASSADO
            $sql = '
                SELECT i.id, i.nome, ' .
                    'e.id as endereco_id, e.logradouro, e.bairro, ' .
                    'c.id as cidade_id, ' .
                    'gc.lat as cidade_geolocalizacao_lat, gc.lng as cidade_geolocalizacao_lng, gc.id as cidade_geolocalizacao_id, ' .
                    'g.id as instituicao_geolocalizacao_id, g.lat as instituicao_geolocalizacao_lat, g.lng as instituicao_geolocalizacao_lng ' .
                'FROM instituicoes_ensino i ' .
                'INNER JOIN enderecos e ' .
                'ON e.id = i.endereco_id ' .
                'INNER JOIN cidades c ' .
                'ON c.id = e.cidade_id ' .
                'INNER JOIN geolocalizacoes g ' .
                'ON g.id = i.geolocalizacao_id ' .
                'INNER JOIN geolocalizacoes gc ' .
                'ON gc.id = c.geolocalizacao_id ' .
                'WHERE i.id NOT IN ' .
                    '(SELECT ie.instituicao_ensino_id ' .
                        'FROM ' .
                            '(SELECT iem.instituicao_ensino_id, iem.motorista_id, m.id as idMotorista, m.cidade_id as cidadeIdMotorista ' .
                                'FROM instituicao_ensino_motorista iem ' .
                                'LEFT JOIN motoristas m ' .
                                'ON iem.motorista_id = m.id ' .
                                'AND m.cidade_id != ?) ie ' .
                        'WHERE ie.idMotorista IS NULL) ';

            $rsm = new ResultSetMapping();
            $rsm->addEntityResult('\App\Entities\InstituicaoEnsino', 'i');
            $rsm->addFieldResult('i', 'id', 'id'); // alias, coluna-tabela, atributo-entidade
            $rsm->addFieldResult('i', 'nome', 'nome');

            $rsm->addJoinedEntityResult('\App\Entities\Endereco', 'e', 'i', 'endereco');
            $rsm->addFieldResult('e', 'endereco_id', 'id');
            $rsm->addFieldResult('e', 'logradouro', 'logradouro');
            $rsm->addFieldResult('e', 'bairro', 'bairro');

            $rsm->addJoinedEntityResult('\App\Entities\Cidade', 'c', 'e', 'cidade');
            $rsm->addFieldResult('c', 'cidade_id', 'id');

            $rsm->addJoinedEntityResult('\App\Entities\Geolocalizacao', 'g', 'i', 'geolocalizacao');
            $rsm->addFieldResult('g', 'instituicao_geolocalizacao_id', 'id');
            $rsm->addFieldResult('g', 'instituicao_geolocalizacao_lat', 'lat');
            $rsm->addFieldResult('g', 'instituicao_geolocalizacao_lng', 'lng');

            $rsm->addJoinedEntityResult('\App\Entities\Geolocalizacao', 'gc', 'c', 'geolocalizacao');
            $rsm->addFieldResult('gc', 'cidade_geolocalizacao_id', 'id');
            $rsm->addFieldResult('gc', 'cidade_geolocalizacao_lat', 'lat');
            $rsm->addFieldResult('gc', 'cidade_geolocalizacao_lng', 'lng');

            $query = $entityManager->createNativeQuery($sql, $rsm);

            $query->setParameter(1, $cidadeId);

            $instituicoesEncontradas = $query->getResult();

            return $instituicoesEncontradas;
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

    public function buscarInstituicoesSemVeiculo($cidadeId)
    {
        $entityManager = $this->getEntityManager();

        try
        { // CONSULTA DEVE RETORNAR INSTITUIÇÕES QUE NÃO TENHAM VEÍCULO ASSOCIADO AO MUNICÍPIO PASSADO
            $sql = '
                SELECT i.id, i.nome, ' .
                    'e.id as endereco_id, e.logradouro, e.bairro, ' .
                    'c.id as cidade_id, ' .
                    'gc.lat as cidade_geolocalizacao_lat, gc.lng as cidade_geolocalizacao_lng, gc.id as cidade_geolocalizacao_id, ' .
                    'g.id as instituicao_geolocalizacao_id, g.lat as instituicao_geolocalizacao_lat, g.lng as instituicao_geolocalizacao_lng ' .
                'FROM instituicoes_ensino i ' .
                'INNER JOIN enderecos e ' .
                'ON e.id = i.endereco_id ' .
                'INNER JOIN cidades c ' .
                'ON c.id = e.cidade_id ' .
                'INNER JOIN geolocalizacoes g ' .
                'ON g.id = i.geolocalizacao_id ' .
                'INNER JOIN geolocalizacoes gc ' .
                'ON gc.id = c.geolocalizacao_id ' .
                'WHERE i.id NOT IN ' .
                    '(SELECT ie.instituicao_ensino_id ' .
                        'FROM ' .
                            '(SELECT iev.instituicao_ensino_id, iev.veiculo_transporte_id, v.id as idVeiculo, v.cidade_id as cidadeIdVeiculo ' .
                                'FROM instituicao_ensino_veiculo_transporte iev ' .
                                'LEFT JOIN veiculos_transporte v ' .
                                'ON iev.veiculo_transporte_id = v.id ' .
                                'AND v.cidade_id != ?) ie ' .
                        'WHERE ie.idVeiculo IS NULL)';

            $rsm = new ResultSetMapping();
            $rsm->addEntityResult('\App\Entities\InstituicaoEnsino', 'i');
            $rsm->addFieldResult('i', 'id', 'id'); // alias, coluna-tabela, atributo-entidade
            $rsm->addFieldResult('i', 'nome', 'nome');

            $rsm->addJoinedEntityResult('\App\Entities\Endereco', 'e', 'i', 'endereco');
            $rsm->addFieldResult('e', 'endereco_id', 'id');
            $rsm->addFieldResult('e', 'logradouro', 'logradouro');
            $rsm->addFieldResult('e', 'bairro', 'bairro');

            $rsm->addJoinedEntityResult('\App\Entities\Cidade', 'c', 'e', 'cidade');
            $rsm->addFieldResult('c', 'cidade_id', 'id');

            $rsm->addJoinedEntityResult('\App\Entities\Geolocalizacao', 'g', 'i', 'geolocalizacao');
            $rsm->addFieldResult('g', 'instituicao_geolocalizacao_id', 'id');
            $rsm->addFieldResult('g', 'instituicao_geolocalizacao_lat', 'lat');
            $rsm->addFieldResult('g', 'instituicao_geolocalizacao_lng', 'lng');

            $rsm->addJoinedEntityResult('\App\Entities\Geolocalizacao', 'gc', 'c', 'geolocalizacao');
            $rsm->addFieldResult('gc', 'cidade_geolocalizacao_id', 'id');
            $rsm->addFieldResult('gc', 'cidade_geolocalizacao_lat', 'lat');
            $rsm->addFieldResult('gc', 'cidade_geolocalizacao_lng', 'lng');

            $query = $entityManager->createNativeQuery($sql, $rsm);

            $query->setParameter(1, $cidadeId);

            $instituicoesEncontradas = $query->getResult();

            return $instituicoesEncontradas;
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

    public function buscarInstituicoesSemRota($cidadeId)
    {
        $entityManager = $this->getEntityManager();

        try
        { // CONSULTA DEVE RETORNAR INSTITUIÇÕES QUE NÃO TENHAM VEÍCULO ASSOCIADO AO MUNICÍPIO PASSADO
            $sql = '
                SELECT i.id, i.nome, ' .
                    'e.id as endereco_id, e.logradouro, e.bairro, ' .
                    'c.id as cidade_id, ' .
                    'gc.lat as cidade_geolocalizacao_lat, gc.lng as cidade_geolocalizacao_lng, gc.id as cidade_geolocalizacao_id, ' .
                    'g.id as instituicao_geolocalizacao_id, g.lat as instituicao_geolocalizacao_lat, g.lng as instituicao_geolocalizacao_lng ' .
                'FROM instituicoes_ensino i ' .
                'INNER JOIN enderecos e ' .
                'ON e.id = i.endereco_id ' .
                'INNER JOIN cidades c ' .
                'ON c.id = e.cidade_id ' .
                'INNER JOIN geolocalizacoes g ' .
                'ON g.id = i.geolocalizacao_id ' .
                'INNER JOIN geolocalizacoes gc ' .
                'ON gc.id = c.geolocalizacao_id ' .
                'WHERE i.id NOT IN ' .
                    '(SELECT ie.instituicao_ensino_id ' .
                        'FROM ' .
                            '(SELECT ier.instituicao_ensino_id, ier.rota_id, r.id as idRota, r.cidade_id as cidadeIdRota ' .
                                'FROM instituicao_ensino_rota ier ' .
                                'LEFT JOIN rota r ' .
                                'ON ier.rota_id = r.id ' .
                                'AND r.cidade_id != ?) ie ' .
                        'WHERE ie.idVeiculo IS NULL)';

            $rsm = new ResultSetMapping();
            $rsm->addEntityResult('\App\Entities\InstituicaoEnsino', 'i');
            $rsm->addFieldResult('i', 'id', 'id'); // alias, coluna-tabela, atributo-entidade
            $rsm->addFieldResult('i', 'nome', 'nome');

            $rsm->addJoinedEntityResult('\App\Entities\Endereco', 'e', 'i', 'endereco');
            $rsm->addFieldResult('e', 'endereco_id', 'id');
            $rsm->addFieldResult('e', 'logradouro', 'logradouro');
            $rsm->addFieldResult('e', 'bairro', 'bairro');

            $rsm->addJoinedEntityResult('\App\Entities\Cidade', 'c', 'e', 'cidade');
            $rsm->addFieldResult('c', 'cidade_id', 'id');

            $rsm->addJoinedEntityResult('\App\Entities\Geolocalizacao', 'g', 'i', 'geolocalizacao');
            $rsm->addFieldResult('g', 'instituicao_geolocalizacao_id', 'id');
            $rsm->addFieldResult('g', 'instituicao_geolocalizacao_lat', 'lat');
            $rsm->addFieldResult('g', 'instituicao_geolocalizacao_lng', 'lng');

            $rsm->addJoinedEntityResult('\App\Entities\Geolocalizacao', 'gc', 'c', 'geolocalizacao');
            $rsm->addFieldResult('gc', 'cidade_geolocalizacao_id', 'id');
            $rsm->addFieldResult('gc', 'cidade_geolocalizacao_lat', 'lat');
            $rsm->addFieldResult('gc', 'cidade_geolocalizacao_lng', 'lng');

            $query = $entityManager->createNativeQuery($sql, $rsm);

            $query->setParameter(1, $cidadeId);

            $instituicoesEncontradas = $query->getResult();

            return $instituicoesEncontradas;
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

    public function buscarInstituicoesComRota($cidadeId)
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $query = $entityManager->createQuery(
                'SELECT i ' .
                    'FROM ' . $this->getTypeObject() . ' i ' .
                    'JOIN \App\Entities\Rota r ' .
                    'JOIN r.cidade c ' .
                    'JOIN r.instituicoesEnsino ri ' .
                    'WHERE ri.id = i.id AND c.id = :cidadeId'
            );
            $query->setParameter('cidadeId', $cidadeId);

            return $query->getResult();
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
        return '\App\Entities\InstituicaoEnsino';
    }
}
