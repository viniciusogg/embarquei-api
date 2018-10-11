<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\InstituicaoEnsinoRepositoryInterface;
use App\Repositories\Abstraction\Repository;
use App\Services\MotoristaService;
use App\Exceptions\NaoEncontradoException;

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
    
    public function  associarComMotorista($motorista, $nomesInstituicoes)
    {
        $instituicoesEnsino = [];
        
        $motoristas = [];
        $motoristas[] = $motorista;
        
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        try
        {
            foreach($nomesInstituicoes as $nomeInstituicao) 
            {
                $instituicaoEnsino = $entityManager->getRepository($this->getTypeObject())->
                        findOneBy(['nome' => $nomeInstituicao]);
                                
                $instituicaoEnsino->setMotoristas($motoristas);
                
                $instituicoesEnsino[] = $instituicaoEnsino;
                
                $entityManager->merge($instituicaoEnsino);
            }
            $motorista->setInstituicoesEnsino($instituicoesEnsino);
            
            $repositoryMotorista = $this->getEntityManager()->getRepository('\App\Entities\Motorista');
            $repositoryMotorista->getEntityManager()->persist($motorista);
            
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
    
    public function associarComCidade($instituicaoEnsino, $nomeCidade)
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
    
    protected function getTypeObject() 
    {
        return '\App\Entities\InstituicaoEnsino';
    }
}
