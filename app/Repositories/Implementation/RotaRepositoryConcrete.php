<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\RotaRepositoryInterface;
//use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Rota;

class RotaRepositoryConcrete extends Repository implements RotaRepositoryInterface
{
    public function associarComEntidades($rota, $nomesInstituicoesEnsino)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        $repositoryInstituicaoEnsino = $this->getEntityManager()->getRepository('\App\Entities\InstituicaoEnsino');
        $repositoryTrajeto = $this->getEntityManager()->getRepository('\App\Entities\Trajeto');
        
//        $rota->setInstituicoesEnsino(new ArrayCollection());

        try
        {
//            $instituicoesEnsino = [];    
            
            $novaRota = new Rota();
            
            $novaRota = $rota;
            
            foreach($nomesInstituicoesEnsino as $nomeInstituicao) 
            {
//                error_log($nomeInstituicao['nome']);
                $instituicaoEnsino = $repositoryInstituicaoEnsino->findOneBy(['nome' => $nomeInstituicao['nome']]);
                                
                //$instituicoesEnsino[] = $instituicaoEnsino;             
                
                $novaRota->getInstituicoesEnsino()->add($instituicaoEnsino);
            }
            $entityManager->persist($rota);
                        
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
    
    protected function getTypeObject() 
    {
        return '\App\Entities\Rota';
    }
}
