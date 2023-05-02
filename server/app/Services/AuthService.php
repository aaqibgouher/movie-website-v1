<?php

namespace App\Services;

use Exception;
use App\Services\UserService;
use App\Services\UserTokenService;
use Illuminate\Support\Facades\Hash;

// Interface
interface AuthInterface {
    public static function register($name, $email, $password);
    public static function encrypt_password($password);
    public static function login($email, $password);
    public static function check_password($user_password, $password);
    public static function logout($user_id, $token);
}

class AuthService implements AuthInterface {
    // register
    public static function register($name, $email, $password) {
        // adding user
        $user_id = UserService::add($name, $email, $password);

        // calling login method after adding user
        $user = AuthService::login($email, $password);

        // returning user data
        return $user;
    }

    // encypting password
    public static function encrypt_password($password) {
        return bcrypt($password);
    }

    // login
    public static function login($email, $password) {
        // validation
        if(!$email) throw new Exception('Email is required.');
        if(!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $email)) throw new Exception("Valid email is required.");
        if(!$password) throw new Exception("Password is required.");

        // get user by email
        $user = UserService::get_by_email($email);
        
        // if user not found, error
        if(!$user) throw new Exception("Email does not exists.");

        // if entered password and original password not matched
        if(!AuthService::check_password($password, $user -> password)) throw new Exception("Email/Password is invalid.");
        
        // generating token by user id
        $token = UserTokenService::generate_jwt_token($user -> id);

        // deleting expired tokens by user id
        UserTokenService::delete_expired_tokens($user -> id);

        // inserting token by user id
        UserTokenService::insert_token_by_user_id($user -> id, $token);
        
        // returning object
        return [
            "user_id" => $user -> id,
            "email" => $user -> email,
            "token" => $token
        ];
    }

    // check entered password with original password
    public static function check_password($user_password, $password) {
        return Hash::check($user_password, $password) ? true : false;
    }

    // logout
    public static function logout($user_id, $token) {
        // brining user token by user id and token
        $user_token = UserTokenService::get_user_token_by_user_id_and_token($user_id, $token);
        
        // deleting from db
        $user_token -> delete();
    }
}