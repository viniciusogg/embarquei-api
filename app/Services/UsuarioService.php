<?php

namespace App\Services;

use App\Repositories\Abstraction\UsuarioRepositoryInterface;
use App\Repositories\Implementation\UsuarioRepositoryConcrete;
use App\Entities\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioService
{
    private $usuarioRepository;

    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    /*
    public function create($data)
    {
        $usuario = new Usuario();

        $usuario->setNome($data['nome']);
        $usuario->setSobrenome($data['sobrenome']);
        $usuario->setNumeroCelular($data['numeroCelular']);
        $usuario->setSenha(Hash::make($data['senha']));

        $this->usuarioRepository->create($usuario);
    }*/

    public function findById($id)
    {
        return $this->usuarioRepository->getById($id);
    }
    
    public function getTipoByNumeroCelular($numeroCelular)
    {
        return $this->usuarioRepository->getTipoByNumeroCelular($numeroCelular);
    }
    
    public function getTipoById($id)
    {
        return $this->usuarioRepository->getTipoById($id);
    }

    public function findAll()
    {
        $result = $this->usuarioRepository->getAll();

        $usuarios = array();

        foreach ($result as $usuario) {
            $usuarios[] = $usuario->toArray();
        }

        return $usuarios;
    }

    /*
    public function update($data, $id)
    {
        $senha = $data['senha'];

        if (Hash::needsRehash($data['senha']))
        {
            $senha = Hash::make($data['senha']);
        }

        $usuario = new Usuario($data['nome'], $data['sobrenome'],
                $data['numeroCelular'], $senha);
        $usuario->setId($id);

        return  $this->usuarioRepository->update($usuario);
    }*/

    public function delete($id)
    {
        $this->usuarioRepository->delete($id);
    }

}
