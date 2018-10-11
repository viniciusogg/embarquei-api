<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\RotaRepositoryInterface;
use App\Entities\Rota;
use App\Exceptions\NullFieldException;

class RotaRepositoryConcrete extends Repository implements RotaRepositoryInterface
{
    public function associarComEntidades($rota, $nomesInstituicoesEnsino)
    {
        $instituicoesEnsino = [];                
        
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        $repositoryInstituicaoEnsino = $entityManager->getRepository('\App\Entities\InstituicaoEnsino');
        $repositoryTrajeto = $entityManager->getRepository('\App\Entities\Trajeto');
        
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
            
            $entityManager->persist($rota);
                        
//            if(!empty($rota->getTrajetos()))
//            {
                foreach ($rota->getTrajetos() as $trajeto)
                {
                    $repositoryTrajeto->getEntityManager()->persist($trajeto);
                }
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
    
    protected function getTypeObject() 
    {
        return '\App\Entities\Rota';
    }
}
