<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsuarioService;
use Illuminate\Http\Response;
use Auth;
use App\Entities\Usuario;

class UsuarioController extends Controller
{
    private $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }
    
    public function tipoById($id)
    {
        $tipo = $this->usuarioService->getTipoById($id);

        if ($tipo)
        {
            return response()->json(['tipo' => $tipo], 200);
        }
        return response()->json(['response' => 'Usuário não encontrado'], 400);
    }

    protected function getService()
    {
        return $this->usuarioService;
    }

    protected function getMensagemErro()
    {
        return 'Usuário não encontrado';
    }


}
