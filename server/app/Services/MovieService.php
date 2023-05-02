<?php

namespace App\Services;

use Exception;
use \GuzzleHttp\Client;
use App\Services\OMDBService;
use App\Services\UserService;
use App\Models\UserFavouriteModel;

// interface
interface MovieInterface {
    public static function get_movies($params = []);
    public static function get_movie_by_imdb_id($imdb_id);
    public static function add_to_favourite($request, $user_id, $imdb_id, $params = []);
    public static function delete_from_favourites($request, $user_id, $imdb_id);
    public static function get_favourites($user_id);
}

class MovieService implements MovieInterface {
    // get movies
    public static function get_movies($params = []) {

        // calling omdb service
        return OMDBService::get_movies($params);
    }

    // get movies by id
    public static function get_movie_by_imdb_id($imdb_id) {
        // calling omdb service
        $movie = OMDBService::get_movie_by_imdb_id($imdb_id);
        
        // if err, throw
        if($movie['Response'] === 'False' || $movie['Response'] === 'false') throw new Exception("Please enter valid IMDB Id.");

        // if not, return movie
        return $movie;
    }

    // add to fav
    public static function add_to_favourite($request, $user_id, $imdb_id, $params = []) {
        // validations
        if(!$user_id) throw new Exception('User id is required.');
        if(!$imdb_id) throw new Exception('IMDB id is required.');

        if(!isset($params['title']) || empty($params['title'])) throw new Exception('Title is required');
        if(!isset($params['year']) || empty($params['year'])) throw new Exception('Year is required');
        if(!isset($params['type']) || empty($params['type'])) throw new Exception('Type is required');
        if(!isset($params['poster']) || empty($params['poster'])) throw new Exception('Poster is required');

        // taking user from request
        $auth_user = $request->attributes->get('user');

        // calling service file
        $user_fav = UserService::get_user_fav_by_user_id_and_imdb_id($auth_user['id'], $imdb_id);

        // if movie exists for a user, throw err
        if($user_fav) throw new Exception('Already in favourites.');

        // add
        $user_favourite = new UserFavouriteModel();
        $user_favourite -> user_id = $user_id;
        $user_favourite -> imdb_id = $imdb_id;
        $user_favourite -> title = $params['title'];
        $user_favourite -> year = $params['year'];
        $user_favourite -> type = $params['type'];
        $user_favourite -> poster = $params['poster'];
        $user_favourite -> save();

        // return id
        return $imdb_id;
    }

    // delete
    public static function delete_from_favourites($request, $user_id, $imdb_id) {
        // validations
        if(!$user_id) throw new Exception('User id is required.');
        if(!$imdb_id) throw new Exception('IMDB id is required.');

        // user from request
        $auth_user = $request->attributes->get('user');

        // calling service
        $user_favourite = UserService::get_user_fav_by_user_id_and_imdb_id($auth_user['id'], $imdb_id);

        // if not in fav, throw err
        if(!$user_favourite) throw new Exception('Not in your favourites.');

        // delete
        $user_favourite -> delete();

        // return id
        return $imdb_id;
    }

    // get fav
    public static function get_favourites($user_id) {
        // calling service
        return UserService::get_user_fav_by_user_id($user_id);
    }
}