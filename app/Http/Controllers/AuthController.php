<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\AdministradorService;
use App\Services\MotoristaService;
use App\Services\EstudanteService;
use App\Services\UsuarioService;
use Illuminate\Support\Facades\Cookie;
use Lcobucci\JWT\Parser;
use App\Exceptions\InvalidCredentialsException;


class AuthController extends Controller
{
    private $authService;
    private $usuarioService;
    private $estudanteService;
    private $adminService;
    private $motoristaService;

    public function __construct(AuthService $authService, EstudanteService $estudanteService,
            AdministradorService $adminService, MotoristaService $motoristaService,
            UsuarioService $usuarioService)
    {
        $this->authService = $authService;
        $this->usuarioService = $usuarioService;
        $this->adminService = $adminService;
        $this->estudanteService = $estudanteService;
        $this->motoristaService = $motoristaService;
    }

    public function auth(Request $request)
    {
        $numeroCelular = $request->get('numeroCelular');
        
        if(!$numeroCelular)
        {
            return $this->refresh();
        }
        else
        {
            return $this->login($request);
        }
    }
    
    public function login(Request $request)
    {
        $numeroCelular = $request->get('numeroCelular');
        
        if(!$this->existeUsuario($numeroCelular))
        {
            error_log('nao existe');
            throw new InvalidCredentialsException();
        }
        
        $senha = $request->get('senha');
        
        $dataTokens = $this->authService->
                attemptLogin($numeroCelular, $senha);

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
        $authorizationHeader = $request->header('Authorization'); //get('access_token');

        $accessToken = str_replace(' ', '', str_replace('Bearer', '', $authorizationHeader));
        
//        error_log($accessToken);
        
        $id = (new Parser())->parse($accessToken)->getHeader('jti');

        $this->authService->logout($id);

        return response()->json(null, 204);
    }
    
    private function existeUsuario($numeroCelular)
    {
        $tipoUsuario = $this->usuarioService->getTipoByNumeroCelular($numeroCelular);
      
        if(!$tipoUsuario)
        {
            return false;
        }
        
        return true;
    }

    protected function getService() {}

    protected function getMensagemErro() {}

}
