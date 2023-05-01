<?php

namespace App\Services;

use Exception;
use App\Services\UserService;
use App\Services\UserTokenService;
use Illuminate\Support\Facades\Hash;

interface AuthInterface {
    public static function register($name, $email, $password);
    public static function encrypt_password($password);
    public static function login($email, $password);
    public static function check_password($user_password, $password);
    public static function logout($user_id, $token);
}

class AuthService implements AuthInterface {
    public static function register($name, $email, $password) {
        $user_id = UserService::add($name, $email, $password);
        $user = AuthService::login($email, $password);
        return $user;
    }

    public static function encrypt_password($password) {
        return bcrypt($password);
    }

    public static function login($email, $password) {
        // validation
        if(!$email) throw new Exception('Email is required.');
        if(!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $email)) throw new Exception("Valid email is required.");
        if(!$password) throw new Exception("Password is required.");

        // get user by email
        $user = UserService::get_by_email($email);

        if(!$user) throw new Exception("Email does not exists.");
        if(!AuthService::check_password($password, $user -> password)) throw new Exception("Email/Password is invalid.");

        $token = UserTokenService::generate_jwt_token($user -> id);
        UserTokenService::delete_expired_tokens($user -> id);
        UserTokenService::insert_token_by_user_id($user -> id, $token);

        return [
            "user_id" => $user -> id,
            "email" => $user -> email,
            "token" => $token
        ];
    }

    public static function check_password($user_password, $password) {
        return Hash::check($user_password, $password) ? true : false;
    }

    public static function logout($user_id, $token) {
        $user_token = UserTokenService::get_user_token_by_user_id_and_token($user_id, $token);
        
        $user_token -> delete();
    }
}