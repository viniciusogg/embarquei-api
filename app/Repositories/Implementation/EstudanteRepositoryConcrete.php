<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\EstudanteRepositoryInterface;
use App\Repositories\Abstraction\Repository;
use App\Repositories\Implementation\UsuarioRepositoryConcrete;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Enums\STATUS_CHECKIN;
use App\Entities\Endereco;
use App\Entities\Checkin;
use App\Entities\ListaPresenca;
use Exception;
use Carbon\Carbon;

class EstudanteRepositoryConcrete extends UsuarioRepositoryConcrete implements EstudanteRepositoryInterface
{
    public function cadastrar($estudante, $idsPontosParada, $idCurso, $endereco)
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

            return $entityManager->merge($estudante);
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
//        $pontosParadaEstudante = [];
        
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        $repositoryPontoParada = $entityManager->getRepository('\App\Entities\PontoParada');
        $repositoryCurso = $entityManager->getRepository('\App\Entities\Curso');
        $repositoryCidade = $entityManager->getRepository('\App\Entities\Cidade');

        try
        {
            if ($estudante->getSenha() === null)
            {
                $senha = $entityManager->find($this->getTypeObject(), $estudante->getId())->getSenha();
                $estudante->setSenha($senha);
            }

            foreach($idsPontosParada as $pontoParada)
            {
                $idPontoParada = $pontoParada['id'];
                $pontoParadaBuscado = $repositoryPontoParada->findOneBy(['id' => $idPontoParada]);
                
                if($pontoParadaBuscado)
                {
                    $estudante->getPontosParada()->add($pontoParadaBuscado);
//                    throw new NaoEncontradoException();
                }
//                $pontosParadaEstudante[] = $pontoParadaBuscado;
            }
            $cidade = $repositoryCidade->findOneBy(['id' => $endereco['cidade']['id']]);
            $curso = $repositoryCurso->findOneBy(['id' => $idCurso]);
                        
            $instanciaEndereco = new Endereco();
            $instanciaEndereco->setId($endereco['id']);
            $instanciaEndereco->setBairro($endereco['bairro']);
            $instanciaEndereco->setLogradouro($endereco['logradouro']);
            $instanciaEndereco->setCidade($cidade);
            
            $estudante->setEndereco($instanciaEndereco);
//            $estudante->setPontosParada($pontosParadaEstudante);
            $estudante->setCurso($curso);
                        
            $entityManager->clear();
            $estudanteAtualizado = $entityManager->merge($estudante);
                        
            foreach($estudante->getPontosParada() as $pontoParadaEstudante)
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
    
    public function alterarStatus($id, $dados)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        
        try
        {
            $estudanteDesatualizado = $entityManager->find($this->getTypeObject(), $id);
            
            $estudanteDesatualizado->setAtivo($dados['ativo']);
            $estudanteDesatualizado->getComprovanteMatricula()->setJustificativa($dados['justificativaComprovante']);
            $estudanteDesatualizado->getComprovanteMatricula()->setStatus($dados['statusComprovante']);
            
            $estudanteAtualizado = $entityManager->merge($estudanteDesatualizado);

            $entityManager->flush();

            if ($dados['ativo']) /* ADICIONANDO ESTUDANTE NA LISTA DE PRESENÇA */
            {
                $this->adicionarNaListaDePresenca($estudanteAtualizado, $entityManager);
            }
            else{ /* REMOVENDO ESTUDANTE DA LISTA DE PRESENÇA */
                $this->removerDaListaDePresenca($estudanteAtualizado, $entityManager);
            }            
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

    private function adicionarNaListaDePresenca($estudante, $entityManager)
    {
        $repositoryListaPresenca = $entityManager->getRepository('\App\Entities\ListaPresenca');

        $cidadeId = $estudante->getEndereco()->getCidade()->getId();
        $instituicaoId = $estudante->getCurso()->getInstituicaoEnsino()->getId();

        $checkinAluno = new Checkin();
        $checkinAluno->setEstudante($estudante);
        $checkinAluno->setStatus(STATUS_CHECKIN::AGUARDANDO_CONFIRMACAO);
        $checkinAluno->setDataUltimaAtualizacao(Carbon::now());

        $query = $entityManager->createQuery(
            'SELECT lp FROM \App\Entities\ListaPresenca lp '
                . 'JOIN lp.cidade c JOIN lp.instituicaoEnsino ie '
                . 'WHERE c.id = :cidadeId AND ie.id = :instituicaoId'
        );
        $query->setParameters(array('cidadeId' => $cidadeId, 'instituicaoId' => $instituicaoId));

        $listaEncontrada = $query->getOneOrNullResult();

        if (!$listaEncontrada) // CRIA UMA LISTA DE PRESENÇA
        {
            $repositoryInstituicaoEnsino = $entityManager->getRepository('\App\Entities\InstituicaoEnsino');
            $repositoryCidade = $entityManager->getRepository('\App\Entities\Cidade');

            $instituicaoEnsino = $repositoryInstituicaoEnsino->findOneBy(['id' => $instituicaoId]);
            $cidade = $repositoryCidade->findOneBy(['id' => $cidadeId]);

            $listaEncontrada = new ListaPresenca();
            $listaEncontrada->setInstituicaoEnsino($instituicaoEnsino);
            $listaEncontrada->setCidade($cidade);

            $repositoryListaPresenca->getEntityManager()->persist($listaEncontrada);
            $repositoryListaPresenca->getEntityManager()->flush();
            $listaSalva = $repositoryListaPresenca->getEntityManager()->merge($listaEncontrada);
            $listaEncontrada = $listaSalva;
        }
        $listaEncontrada->getCheckins()->add($checkinAluno);
        $checkinAluno->setListaPresenca($listaEncontrada);

        $entityManager->clear();
        $entityManager->merge($checkinAluno);
        $entityManager->flush();
    }
    
    private function removerDaListaDePresenca($estudante, $entityManager)
    {
        $repositoryCheckin = $entityManager->getRepository('\App\Entities\Checkin');

        $checkin = $repositoryCheckin->findOneBy(['estudante' => $estudante]);

        $repositoryCheckin->getEntityManager()->remove($checkin);

        $repositoryCheckin->getEntityManager()->flush();
    }
    
    public function getByCidade($cidadeId) 
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $query = $entityManager->createQuery(
                'SELECT e FROM \App\Entities\Estudante e '
                    . 'JOIN e.endereco en JOIN en.cidade c '
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
