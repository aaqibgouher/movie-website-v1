<?php

namespace App\Services;

use Exception;
use \GuzzleHttp\Client;
use App\Services\OMDBService;
use App\Services\UserService;
use App\Models\UserFavouriteModel;

interface MovieInterface {
    public static function get_movies($params = []);
    public static function get_movie_by_imdb_id($imdb_id);
    public static function add_to_favourite($request, $user_id, $imdb_id, $params = []);
    public static function delete_from_favourites($request, $user_id, $imdb_id);
    public static function get_favourites($user_id);
}

class MovieService implements MovieInterface {
    public static function get_movies($params = []) {
        return OMDBService::get_movies($params);
    }

    public static function get_movie_by_imdb_id($imdb_id) {
        $movie = OMDBService::get_movie_by_imdb_id($imdb_id);
        
        if($movie['Response'] === 'False' || $movie['Response'] === 'false') throw new Exception("Please enter valid IMDB Id.");

        return $movie;
    }

    public static function add_to_favourite($request, $user_id, $imdb_id, $params = []) {
        if(!$user_id) throw new Exception('User id is required.');
        if(!$imdb_id) throw new Exception('IMDB id is required.');

        if(!isset($params['title']) || empty($params['title'])) throw new Exception('Title is required');
        if(!isset($params['year']) || empty($params['year'])) throw new Exception('Year is required');
        if(!isset($params['type']) || empty($params['type'])) throw new Exception('Type is required');
        if(!isset($params['poster']) || empty($params['poster'])) throw new Exception('Poster is required');

        $auth_user = $request->attributes->get('user');
        $user_fav = UserService::get_user_fav_by_user_id_and_imdb_id($auth_user['id'], $imdb_id);

        if($user_fav) throw new Exception('Already in favourites.');

        $user_favourite = new UserFavouriteModel();
        $user_favourite -> user_id = $user_id;
        $user_favourite -> imdb_id = $imdb_id;
        $user_favourite -> title = $params['title'];
        $user_favourite -> year = $params['year'];
        $user_favourite -> type = $params['type'];
        $user_favourite -> poster = $params['poster'];
        $user_favourite -> save();

        return $imdb_id;
    }

    public static function delete_from_favourites($request, $user_id, $imdb_id) {
        if(!$user_id) throw new Exception('User id is required.');
        if(!$imdb_id) throw new Exception('IMDB id is required.');

        $auth_user = $request->attributes->get('user');
        $user_favourite = UserService::get_user_fav_by_user_id_and_imdb_id($auth_user['id'], $imdb_id);

        if(!$user_favourite) throw new Exception('Not in your favourites.');

        $user_favourite -> delete();

        return $imdb_id;
    }

    public static function get_favourites($user_id) {
        return UserService::get_user_fav_by_user_id($user_id);
    }
}