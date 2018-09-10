<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\InstituicaoEnsinoRepositoryInterface;
use App\Repositories\Abstraction\Repository;
use App\Services\MotoristaService;

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
            
            $this->getEntityManager()->getRepository('\App\Entities\Motorista')->getEntityManager()->persist($motorista);
            
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
