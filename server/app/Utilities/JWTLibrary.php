<?php

namespace App\Utilities;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTLibrary {
    public static function encode($user_id) {
        $key = JWTLibrary::get_key();
        $payload = JWTLibrary::get_payload($user_id);
        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }

    public static function decode($jwt) {
        try{
            $key = JWTLibrary::get_key();
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function get_key() {
        return env('JWT_KEY', '');
    }

    public static function get_payload($user_id) {
        return array(
            "user_id" => $user_id,
            "iat" => time(),
            "exp" => time() + 60 * 60 * 24
        );
    }
}