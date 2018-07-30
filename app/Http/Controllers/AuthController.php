<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Support\Facades\Cookie;
use Lcobucci\JWT\Parser;

class AuthController extends Controller
{
    private $authService;
    private $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $matricula = $request->get('matricula');
        $password = $request->get('password');

        $dataTokens = $this->authService->
                attemptLogin($matricula, $password, $this->userService);
        
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
