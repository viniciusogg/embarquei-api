<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\Repository;
use App\Repositories\Abstraction\PontoParadaRepositoryInterface;

class PontoParadaRepositoryConcrete extends Repository implements PontoParadaRepositoryInterface
{

    protected function getTypeObject() 
    {
        return '\App\Entities\PontoParada';
    }
    
    public function getPontosParadaByCidadeInstituicaoRota($cidadeId, $instituicaoId, $rotaId)
    {
        $entityManager = $this->getEntityManager();

        try
        {
//            $query = $entityManager->createQuery(
//                'SELECT p FROM App\Entities\PontoParada p '
//                    . 'JOIN App\Entities\Rota r '
//                    . 'JOIN r.trajetos t '
//                    . 'JOIN r.instituicoesEnsino i '
//                    . 'JOIN r.cidade c '
//                    . 'JOIN t.rota tr '
//                    . 'WHERE c.id = :cidadeId AND i.id = :instituicaoId AND tr.id = :rotaId'
//            );
            $query = $entityManager->createQuery(
                'SELECT t FROM App\Entities\Trajeto t '
                    . 'JOIN App\Entities\Rota r '
                    . 'JOIN r.trajetos rt '
                    . 'JOIN r.instituicoesEnsino i '
                    . 'JOIN r.cidade c '
                    . 'JOIN rt.rota tr '
                    . 'WHERE c.id = :cidadeId AND i.id = :instituicaoId AND tr.id = :rotaId'
            );
            
            $query->setParameters(array(
                'cidadeId' => $cidadeId,
                'instituicaoId' => $instituicaoId,
                'rotaId' => $rotaId
            ));
            
            $pontosParada = $query->getResult();
            
            return $pontosParada;
        }
        catch (Exception $ex) 
        {
            throw $ex;
        }

    }
}
