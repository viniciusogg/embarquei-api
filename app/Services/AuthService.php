<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Application;
use App\Services\UserService;
use App\Exceptions\InvalidCredentialsException;

class AuthService
{
    const REFRESH_TOKEN = 'refresh_token';

    private $cookie;
    private $request;
    private $app;
    
    public function __construct(Application $app) 
    {    
        $this->cookie = $app->make('cookie');

        $this->request = $app->make('request');
        
        $this->app = $app;
    }

    /**
     * Attempt to create an access token using user credentials
     *
     * @param string $email
     * @param string $password
     */
    public function attemptLogin($matricula, $password, UserService $userService)
    {
        $user = $userService->findByMatricula($matricula);
                        
        if (!empty($user)) 
        {
            return $this->proxy('password', [
                'username' => $matricula,
                'password' => $password
            ]);
        }

        throw new InvalidCredentialsException();
    }

    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie
     */
    public function attemptRefresh()
    {
        $refreshToken = $this->request->cookie(self::REFRESH_TOKEN);
         
        return $this->proxy(self::REFRESH_TOKEN, [
            self::REFRESH_TOKEN => $refreshToken
        ]);
    }

    /**
     * Proxy a request to the OAuth server.
     *
     * @param string $grantType what type of grant type should be proxied
     * @param array $data the data to send to the server
     */
    public function proxy($grantType, array $data = [])
    {
        $dataRequest = array_merge($data, [
            'client_id'     => env('LARAVEL_PASSWORD_GRANT_CLIENT_ID'),
            'client_secret' => env('LARAVEL_PASSWORD_GRANT_CLIENT_SECRET'),
            'grant_type'    => $grantType
        ]);

        $request = Request::create('/oauth/token', 'POST', $dataRequest);
        $response = $this->app->handle($request);
                
        if ($response->status() == 401) 
        {
            throw new InvalidCredentialsException();
        }
        
        $response = json_decode($response->content(), true);

        // Create a refresh token cookie
        $this->cookie->queue(
            self::REFRESH_TOKEN,
            $response[self::REFRESH_TOKEN],
            1440, // 1 day
            null,
            null,
            false,
            true // HttpOnly
        );

        return [
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
        ];
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     */
    public function logout($accessTokenId)
    {        
        $this->revokeTokens($accessTokenId);

        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));
    }
    
    private function revokeTokens($id)
    {
        // Revogando refresh token
        DB::table('oauth_refresh_tokens')->
            where('access_token_id', $id)->
            update([
                'revoked' => 1
            ]);

        // Revogando access token        
        DB::table('oauth_access_tokens')->
            where('id', $id)->
            update([
                'revoked' => 1
            ]);
    }
    
}

