<?php
/**
 * Created by PhpStorm.
 * User: vinicius
 * Date: 17/02/19
 * Time: 21:14
 */

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\FeedbackRepositoryInterface;
use App\Repositories\Abstraction\Repository;
use \Exception;
use App\Exceptions\NaoEncontradoException;

class FeedbackRepositoryConcrete extends Repository implements FeedbackRepositoryInterface
{
    public function cadastrar($feedback, $idUsuario)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();

        try
        {
            $usuario = $entityManager->find('\App\Entities\Usuario', $idUsuario);

            if ($usuario)
            {
                $feedback->setUsuario($usuario);
                $entityManager->persist($feedback);
                $entityManager->flush();
                $entityManager->getConnection()->commit();
            }
            else
            {
                throw new NaoEncontradoException();
            }
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
        return '\App\Entities\Feedback';
    }

}