<?php

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\UsuarioRepositoryInterface;
use App\Repositories\Abstraction\Repository;
use Exception;

class UsuarioRepositoryConcrete extends Repository implements UsuarioRepositoryInterface
{

    public function getByNumeroCelular($numeroCelular)
    {
        $entityManager = $this->getEntityManager();

        try
        {
            $result = $entityManager->getRepository($this->getTypeObject())->
                    findBy(['numeroCelular' => $numeroCelular]);

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

    protected function getTypeObject()
    {
        return '\App\Entities\Usuario';
    }
}
