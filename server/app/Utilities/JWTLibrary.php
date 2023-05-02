<?php

namespace App\Utilities;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTLibrary {
    // encode
    public static function encode($user_id) {
        // get key
        $key = JWTLibrary::get_key();
        
        // get payload
        $payload = JWTLibrary::get_payload($user_id);

        // encode
        $jwt = JWT::encode($payload, $key, 'HS256');

        // return
        return $jwt;
    }

    // decode
    public static function decode($jwt) {
        try{
            // get key
            $key = JWTLibrary::get_key();

            // decode
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

            // return
            return $decoded;
        } catch (Exception $e) {
            // err
            throw new Exception($e->getMessage());
            
        }
    }

    // key from env
    public static function get_key() {
        return env('JWT_KEY', '');
    }

    // payload
    public static function get_payload($user_id) {
        return array(
            "user_id" => $user_id,
            "iat" => time(),
            "exp" => time() + 60 * 60 * 24
        );
    }
}