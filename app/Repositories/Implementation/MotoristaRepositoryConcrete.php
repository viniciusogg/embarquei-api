<?php

namespace App\Repositories\Implementation;

use App\Repositories\Implementation\UsuarioRepositoryConcrete;
use App\Repositories\Abstraction\MotoristaRepositoryInterface;
use App\Exceptions\NaoEncontradoException;
use Exception;

class MotoristaRepositoryConcrete extends UsuarioRepositoryConcrete implements MotoristaRepositoryInterface
{
    public function  associarComInstituicao($motorista, $nomesInstituicoes)
    {
        $instituicoesEnsino = [];
        
        $motoristas = [];
        $motoristas[] = $motorista;
        
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        $repositoryInstituicaoEnsino = $entityManager->getRepository('\App\Entities\InstituicaoEnsino');
        
        try
        {
            foreach($nomesInstituicoes as $nomeInstituicao) 
            {                
                $instituicaoEnsino = $repositoryInstituicaoEnsino->
                        findOneBy(['nome' => $nomeInstituicao['nome']]);

                if(!$instituicaoEnsino) 
                {
                    throw new NaoEncontradoException();
                }
                
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
