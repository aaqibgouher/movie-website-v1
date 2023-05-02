<?php

namespace App\Services;

use Exception;
use Validator;
use App\Models\UserModel;
use App\Services\AuthService;
use App\Models\UserFavouriteModel;

// interface
interface UserInterface {
    public static function add($name, $email, $password, $params = []);
    public static function get_by_email($email);
    public static function get_by_id($id);
    public static function get_user_fav_by_user_id_and_imdb_id($user_id, $imdb_id);
    public static function get_user_fav_by_user_id($user_id);
}

class UserService implements UserInterface {
    // get by email
    public static function get_by_email($email) {
        return UserModel::where('email', $email)->first();
    }

    // add user
    public static function add($name, $email, $password, $params = []) {
        // validations
        if(!$name) throw new Exception('Name is required.');
        if(!$email) throw new Exception("Email is required.");
        if(!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $email)) throw new Exception("Valid email is required.");
        if(!$password) throw new Exception("Password is required");

        // get user by email
        $user = UserService::get_by_email($email);
        if($user) throw new Exception('Email already exists.');

        // add
        $user = new UserModel();
        $user -> name = $name;
        $user -> email = $email;
        $user -> password = AuthService::encrypt_password($password);
        $user -> verified = 1;
        $user -> save();

        // return id
        return $user -> id;
    }

    // get by email
    public static function get_by_id($id) {
        // validation
        if(!$id) throw new Exception('User id is required.');

        // find user by id
        $user = UserModel::find($id);

        // if not found, throw err
        if(!$user) throw new Exception('Invalid user id.');

        // return user
        return $user;
    }

    // get user fav by user id and imdb id
    public static function get_user_fav_by_user_id_and_imdb_id($user_id, $imdb_id) {
        return UserFavouriteModel::where('user_id', $user_id)->where('imdb_id', $imdb_id)->first();
    }

    // get user fav by user id
    public static function get_user_fav_by_user_id($user_id) {
        return UserFavouriteModel::where('user_id', $user_id)->get();
    }
}