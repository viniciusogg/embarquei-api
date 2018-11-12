<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\AdministradorRepositoryInterface;
use App\Repositories\Implementation\UsuarioRepositoryConcrete;
use \App\Entities\Endereco;
use Exception;

class AdministradorRepositoryConcrete extends UsuarioRepositoryConcrete implements AdministradorRepositoryInterface
{
    public function associarComEndereco($administrador, $endereco) 
    {                
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        $repositoryCidade = $entityManager->getRepository('\App\Entities\Cidade');

        try
        {
            $cidade = $repositoryCidade->findOneBy(['id' => $endereco['cidadeId']]);
            
            $instanciaEndereco = new Endereco();
            $instanciaEndereco->setBairro($endereco['bairro']);
            $instanciaEndereco->setLogradouro($endereco['logradouro']);
            $instanciaEndereco->setCidade($cidade);
            
            $administrador->setEndereco($instanciaEndereco);
                                    
            $entityManager->persist($administrador);
            
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
        return '\App\Entities\Administrador';
    }
}
