<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UsuarioService;
use Illuminate\Support\Facades\Cookie;
use Lcobucci\JWT\Parser;

class AuthController extends Controller
{
    private $authService;
    private $usuarioService;

    public function __construct(AuthService $authService, UsuarioService $usuarioService)
    {
        $this->authService = $authService;
        $this->usuarioService = $usuarioService;
    }

    public function login(Request $request)
    {
        $numeroCelular = $request->get('numeroCelular');
        $senha = $request->get('senha');

        $dataTokens = $this->authService->
                attemptLogin($numeroCelular, $senha, $this->usuarioService);

        $accessToken = array(
            'access_token' => $dataTokens['access_token'],
            'expires_in' => $dataTokens['expires_in']
        );

        return response()->json($accessToken, 200);
    }

    public function refresh()
    {
        $dataTokens = $this->authService->attemptRefresh();
        
        $accessToken = array(
            'access_token' => $dataTokens['access_token'],
            'expires_in' => $dataTokens['expires_in']
        );

        return response()->json($accessToken, 200);
    }

    public function logout(Request $request)
    {
        $accessToken = $request->get('access_token');

        $id = (new Parser())->parse($accessToken)->getHeader('jti');

        $this->authService->logout($id);

        return response()->json(null, 204);
    }
}
