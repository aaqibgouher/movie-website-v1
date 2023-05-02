<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

// interface
interface OMDBInterface {
    public static function get_movies($params = []);
    public static function get_movie_by_imdb_id($imdb_id);
}  

class OMDBService implements OMDBInterface {
    // get movies
    public static function get_movies($params = []) {
        // check for params
        $page = array_key_exists("page", $params) ? $params['page'] : 1;
        $search = array_key_exists("search", $params) ? $params['search'] : '';
        $type = array_key_exists("type", $params) ? $params['type'] : '';

        // calling api through Http, passing required params
        $response = Http::get(env('OMDB_URL'), [
            'apikey' => env('OMDB_API_KEY'),
            's' => $search ? $search : 'all',
            'plot' => 'full',
            'page' => $page,
            'type' => $type
        ]);

        // return json res
        return $response->json();
    }

    // get movie by imdb id
    public static function get_movie_by_imdb_id($imdb_id) {
        // calling api using http
        $response = Http::get(env('OMDB_URL'), [
            'apikey' => env('OMDB_API_KEY'),
            'i' => $imdb_id,
        ]);

        // return json res
        return $response->json();
    }
}