<?php

namespace App\Repositories\Implementation;

use Illuminate\Support\Facades\DB;
use App\Repositories\Abstraction\UsuarioRepositoryInterface;
use App\Repositories\Abstraction\Repository;
use Doctrine\ORM\Query\ResultSetMapping;
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
    
    public function getTipoByNumeroCelular($numeroCelular) 
    {        
        try
        {              
            return DB::table('usuarios')->
                    where('numero_celular', $numeroCelular)->
                    value('discr');
        }
        catch (Exception $ex) 
        {
            throw $ex;
        }
    }

    public function getTipoById($id)
    {        
        try
        {              
            return DB::table('usuarios')->
                    where('id', $id)->
                    value('discr');
        }
        catch (Exception $ex) 
        {
            throw $ex;
        }
    }
    
    protected function getTypeObject() 
    {
        return '\App\Entities\Usuario';
    }
}
