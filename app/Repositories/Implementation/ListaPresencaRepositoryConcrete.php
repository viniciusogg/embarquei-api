<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\ListaPresencaRepositoryInterface;
use App\Entities\ListaPresenca;
use Exception;

class ListaPresencaRepositoryConcrete extends Repository implements ListaPresencaRepositoryInterface
{
    public function cadastrar($listaPresenca, $cidadeId, $instituicaoId)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        $repositoryInstituicaoEnsino = $entityManager->getRepository('\App\Entities\InstituicaoEnsino');
        $repositoryCidade = $entityManager->getRepository('\App\Entities\Cidade');
        
        try
        {
            $instituicaoEnsino = $repositoryInstituicaoEnsino->findOneBy(['id' => $instituicaoId]);
            $cidade = $repositoryCidade->findOneBy(['id' => $cidadeId]);
            
            $listaPresenca->setInstituicaoEnsino($instituicaoEnsino);
            $listaPresenca->setCidade($cidade);
            
            $entityManager->persist($listaPresenca);
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

    public function adicionarAluno($checkinAluno, $cidadeId, $instituicaoId)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        try
        {
//            $query = $entityManager->createQuery(
//                'SELECT lp FROM \App\Entities\ListaPresenca lp '
//                    . 'JOIN lp.cidade c JOIN lp.instituicaoEnsino ie '
//                    . 'WHERE c.id = :cidadeId AND ie.id = :instituicaoId'
//            );
//            
//            $query->setParameters(array('cidadeId' => $cidadeId, 'instituicaoId' => $instituicaoId));
//
//            $listaEncontrada = $query->getResult();
//            
//            if (!$listaEncontrada) // CRIA UMA LISTA DE PRESENÇA
//            {
//                $repositoryInstituicaoEnsino = $entityManager->getRepository('\App\Entities\InstituicaoEnsino');
//                $repositoryCidade = $entityManager->getRepository('\App\Entities\Cidade');
//
//                $instituicaoEnsino = $repositoryInstituicaoEnsino->findOneBy(['id' => $instituicaoId]);
//                $cidade = $repositoryCidade->findOneBy(['id' => $cidadeId]);
//                
//                $listaEncontrada = new ListaPresenca();
//                $listaEncontrada->setInstituicaoEnsino($instituicaoEnsino);
//                $listaEncontrada->setCidade($cidade);
//                
//                $entityManager->getRepository('\App\Entities\ListaPresenca')->
//                        getEntityManager()->persist($listaEncontrada);
//            }
//                
//            $listaEncontrada->getCheckins()->add($checkinAluno);
//            $checkinAluno->setListaPresenca($listaEncontrada);
//            
//            $entityManager->merge($listaEncontrada);
//            $entityManager->flush();
//            $entityManager->getConnection()->commit();
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
        return '\App\Entities\ListaPresenca';
    }
}
