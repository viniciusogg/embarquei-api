<?php

namespace App\Services;


abstract class Service
{
    public function create($dados)
    {
        $object = $this->criarInstancia($dados);

        $this->getRepository()->create($object);
    }

    public function findById($id)
    {
        return $this->getRepository()->getById($id);
    }

    public function findAll()
    {
        $result = $this->getRepository()->getAll();

        $objetos = array();

        foreach ($result as $objeto) {
            $objetos[] = $objeto->toArray();
        }
        return $objetos;
    }

    public function update($dados, $id)
    {
        $objeto = $this->criarInstancia($dados);
        $objeto->setId($id);

        return $this->getRepository()->update($objeto);
    }

    public function delete($id)
    {
        $this->getRepository()->delete($id);
    }

    protected abstract function criarInstancia($dados);

    protected abstract function getRepository();
}