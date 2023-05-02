<?php

namespace App\Services;

use Exception;
use App\Utilities\JWTLibrary;
use App\Models\UserTokenModel;

// interface
interface UserTokenInterface {
    public static function generate_jwt_token($user_id);
    public static function delete_expired_tokens($user_id);
    public static function insert_token_by_user_id($user_id, $token);
    public static function get_user_token_by_user_id_and_token($user_id, $token);
}

class UserTokenService implements UserTokenInterface {
    // generate jwt
    public static function generate_jwt_token($user_id) {
        return JWTLibrary::encode($user_id);
    }

    // delete expired tokens
    public static function delete_expired_tokens($user_id) {
        // get all tokens for user
        $user_tokens = UserTokenModel::where('user_id', $user_id) -> get();

        // loop over each token
        foreach($user_tokens as $user_token) {
            try {
                // decode
                JWTLibrary::decode($user_token -> token);
            } catch (Exception $e) {
                // if not decode, delete that token
                UserTokenModel::where('user_id', $user_id)->where('token', $user_token -> token) -> delete();
            }
        }
    }

    // insert token
    public static function insert_token_by_user_id($user_id, $token) {
        // insert
        $user_token = new UserTokenModel();
        $user_token -> user_id = $user_id;
        $user_token -> token = $token;
        $user_token -> save();
    }

    // get user token by user id and token
    public static function get_user_token_by_user_id_and_token($user_id, $token) {
        // validations
        if(!$user_id) throw new Exception("User id is required.");
        if(!$token) throw new Exception("Token is required.");

        // return
        return UserTokenModel::where('user_id', $user_id)->where('token', $token)->first();
    }
}