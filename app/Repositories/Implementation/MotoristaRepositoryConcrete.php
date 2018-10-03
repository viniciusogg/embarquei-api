<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\MotoristaRepositoryInterface;
use Exception;

class MotoristaRepositoryConcrete extends Repository implements MotoristaRepositoryInterface
{
    public function  associarComInstituicao($motorista, $nomesInstituicoes)
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
                $instituicaoEnsino = $entityManager->getRepository('\App\Entities\InstituicaoEnsino')->
                        findOneBy(['nome' => $nomeInstituicao['nome']]);

                $instituicaoEnsino->getMotoristas()->add($motorista);

                $instituicoesEnsino[] = $instituicaoEnsino;     
                
                $entityManager->merge($instituicaoEnsino);
            }
            $motorista->setInstituicoesEnsino($instituicoesEnsino);
            
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
    
    protected function getTypeObject() 
    {
        return '\App\Entities\Motorista';
    }
    
}
