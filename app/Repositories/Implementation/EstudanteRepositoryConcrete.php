<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\EstudanteRepositoryInterface;
use App\Repositories\Abstraction\Repository;
use App\Repositories\Implementation\UsuarioRepositoryConcrete;
use App\Entities\Endereco;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class EstudanteRepositoryConcrete extends UsuarioRepositoryConcrete implements EstudanteRepositoryInterface
{

    public function associarComEntidades($estudante, $idsPontosParada, $idCurso, $endereco) 
    {        
        $pontosParadaEstudante = [];
        
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        $repositoryPontoParada = $entityManager->getRepository('\App\Entities\PontoParada');
        $repositoryCurso = $entityManager->getRepository('\App\Entities\Curso');
        $repositoryCidade = $entityManager->getRepository('\App\Entities\Cidade');

        try
        {
            foreach($idsPontosParada as $pontoParada)
            {
                $idPontoParada = $pontoParada['id'];
                $pontoParadaBuscado = $repositoryPontoParada->findOneBy(['id' => $idPontoParada]);
                
                if(!$pontoParadaBuscado) 
                {
                    throw new NaoEncontradoException();
                }

                $pontosParadaEstudante[] = $pontoParadaBuscado;                
            }
            $cidade = $repositoryCidade->findOneBy(['id' => $endereco['cidade']['id']]);
            $curso = $repositoryCurso->findOneBy(['id' => $idCurso]);
            
            $instanciaEndereco = new Endereco();
            $instanciaEndereco->setBairro($endereco['bairro']);
            $instanciaEndereco->setLogradouro($endereco['logradouro']);
            $instanciaEndereco->setCidade($cidade);
            
            $estudante->setEndereco($instanciaEndereco);
            $estudante->setPontosParada($pontosParadaEstudante);
            $estudante->setCurso($curso);
                                    
            $entityManager->persist($estudante);
                        
            foreach($pontosParadaEstudante as $pontoParadaEstudante)
            {
                $pontoParadaEstudante->getEstudantes()->add($estudante);
                $repositoryPontoParada->getEntityManager()->merge($pontoParadaEstudante);
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
    
    public function atualizar($estudante, $idsPontosParada, $idCurso, $endereco)    
    {
//        $pontosParadaEstudante = new ArrayCollection();
        $pontosParadaEstudante = [];
        
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        $repositoryPontoParada = $entityManager->getRepository('\App\Entities\PontoParada');
        $repositoryCurso = $entityManager->getRepository('\App\Entities\Curso');
        $repositoryCidade = $entityManager->getRepository('\App\Entities\Cidade');

        try
        {
            foreach($idsPontosParada as $pontoParada)
            {
                $idPontoParada = $pontoParada['id'];
                $pontoParadaBuscado = $repositoryPontoParada->findOneBy(['id' => $idPontoParada]);
                
                if(!$pontoParadaBuscado) 
                {
                    throw new NaoEncontradoException();
                }
//                $pontosParadaEstudante->add($pontoParadaBuscado);
                $pontosParadaEstudante[] = $pontoParadaBuscado;                
            }
            $cidade = $repositoryCidade->findOneBy(['id' => $endereco['cidade']['id']]);
            $curso = $repositoryCurso->findOneBy(['id' => $idCurso]);
                        
            $instanciaEndereco = new Endereco();
            $instanciaEndereco->setId($endereco['id']);
            $instanciaEndereco->setBairro($endereco['bairro']);
            $instanciaEndereco->setLogradouro($endereco['logradouro']);
            $instanciaEndereco->setCidade($cidade);
            
            $estudante->setEndereco($instanciaEndereco);
            $estudante->setPontosParada($pontosParadaEstudante);
            $estudante->setCurso($curso);
                        
            $entityManager->clear();
            $estudanteAtualizado = $entityManager->merge($estudante);
                        
            foreach($pontosParadaEstudante as $pontoParadaEstudante)
            {
                $pontoParadaEstudante->getEstudantes()->add($estudanteAtualizado);
                $repositoryPontoParada->getEntityManager()->merge($pontoParadaEstudante);
            }
            
            $entityManager->flush();
            $entityManager->getConnection()->commit();
            
            return $estudanteAtualizado;
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
    
    public function getByCidade($cidadeId) 
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $query = $entityManager->createQuery(
                'SELECT e FROM \App\Entities\Estudante e '
//                    . 'JOIN App\Entities\Cidade c '
                    . 'JOIN e.endereco en '
                    . 'JOIN en.cidade c '
                    . 'WHERE c.id = :cidadeId'
            );
            
            $query->setParameter('cidadeId', $cidadeId);
            
            $estudantes = $query->getResult();
            
            return $estudantes;
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
        return '\App\Entities\Estudante';
    }
}
