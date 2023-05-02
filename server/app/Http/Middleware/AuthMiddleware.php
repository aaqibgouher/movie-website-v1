<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Utilities\Output;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Utilities\JWTLibrary;
use App\Services\UserTokenService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // get the token from request
            $token = $request -> bearerToken();

            // if token false, err
            if(!$token) throw new Exception("JWT is required.");
            // decode the token, and get token data
            $token_data = JWTLibrary::decode($token);
            
            // taking user id rom token data
            $user_id = $token_data -> user_id;

            // get user by id
            $user = UserService::get_by_id($user_id);

            // check if user id and token exists in db
            $user_token = UserTokenService::get_user_token_by_user_id_and_token($user_id, $token);
            if(!$user_token) throw new Exception('User id and token is not present in DB');
            
            // clonning obj, and adding token
            $request_obj = clone $user;
            $request_obj -> token = $token;

            // setting user data in request obj
            $request->attributes->set('user', $request_obj);
            return $next($request);
        } catch (Exception $e) {
            // if err, unauthorized
            return Output::unauthorize();
        }
    }
}
