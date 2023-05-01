<?php

namespace App\Services;

use Exception;
use App\Utilities\JWTLibrary;
use App\Models\UserTokenModel;

interface UserTokenInterface {
    public static function generate_jwt_token($user_id);
    public static function delete_expired_tokens($user_id);
    public static function insert_token_by_user_id($user_id, $token);
    public static function get_user_token_by_user_id_and_token($user_id, $token);
}

class UserTokenService implements UserTokenInterface {
    public static function generate_jwt_token($user_id) {
        return JWTLibrary::encode($user_id);
    }

    public static function delete_expired_tokens($user_id) {
        $user_tokens = UserTokenModel::where('user_id', $user_id) -> get();

        foreach($user_tokens as $user_token) {
            try {
                JWTLibrary::decode($user_token -> token);
            } catch (Exception $e) {
                UserTokenModel::where('user_id', $user_id)->where('token', $user -> token) -> delete();
            }
        }
    }

    public static function insert_token_by_user_id($user_id, $token) {
        $user_token = new UserTokenModel();
        $user_token -> user_id = $user_id;
        $user_token -> token = $token;
        $user_token -> save();
    }

    public static function get_user_token_by_user_id_and_token($user_id, $token) {
        if(!$user_id) throw new Exception("User id is required.");
        if(!$token) throw new Exception("Token is required.");

        return UserTokenModel::where('user_id', $user_id)->where('token', $token)->first();
    }
}