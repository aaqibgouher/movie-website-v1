<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

interface OMDBInterface {
    public static function get_movies($params = []);
    public static function get_movie_by_imdb_id($imdb_id);
}  

class OMDBService implements OMDBInterface {
    public static function get_movies($params = []) {
        $page = array_key_exists("page", $params) ? $params['page'] : 1;
        $search = array_key_exists("search", $params) ? $params['search'] : '';
        $type = array_key_exists("type", $params) ? $params['type'] : '';

        $response = Http::get(env('OMDB_URL'), [
            'apikey' => env('OMDB_API_KEY'),
            's' => $search ? $search : 'all',
            'plot' => 'full',
            'page' => $page,
            'type' => $type
        ]);

        return $response->json();
    }

    public static function get_movie_by_imdb_id($imdb_id) {
        $response = Http::get(env('OMDB_URL'), [
            'apikey' => env('OMDB_API_KEY'),
            'i' => $imdb_id,
        ]);

        return $response->json();
    }
}