<?php

namespace App\Http\Controllers;

use Exception;
use App\Utilities\Output;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\MovieService;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function __construct() {
        DB::beginTransaction();
    }

    public function get_movies(Request $request) {
        try {
            $page = trim($request -> input('page'));
            $search = trim($request -> input('search'));
            $type = trim($request -> input('type'));

            $params = [
                "page" => $page,
                "search" => $search,
                "type" => $type
            ];

            $data = MovieService::get_movies($params);

            return Output::success('Successfully get the data.', $data);
        } catch (Exception $e) {
            DB::rollback();
            return Output::error($e -> getMessage());
        }
    }

    public function get_movie_by_imdb_id(Request $request, $imdb_id) {
        try {
            // echo gettype($imdb_id);
            $data = MovieService::get_movie_by_imdb_id($imdb_id);

            return Output::success('Successfully get a movie detail.', $data);
        } catch (Exception $e) {
            return Output::error($e -> getMessage());
        }
    }

    public function add_to_favourite(Request $request, $imdb_id) {
        try {
            $title = trim($request -> input('title'));
            $year = trim($request -> input('year'));
            $type = trim($request -> input('type'));
            $poster = trim($request -> input('poster'));

            $params = [
                "title" => $title,
                "year" => $year,
                "type" => $type,
                "poster" => $poster
            ];

            $auth_user = $request->attributes->get('user');
            $data = MovieService::add_to_favourite($request, $auth_user['id'], $imdb_id, $params);

            DB::commit();

            return Output::success('Successfully added to favourites.', $data);
        } catch (Exception $e) {
            DB::rollback();
            return Output::error($e -> getMessage());
        }
    }

    public function delete_from_favourites(Request $request, $imdb_id) {
        try {
            $auth_user = $request->attributes->get('user');
            $data = MovieService::delete_from_favourites($request, $auth_user['id'], $imdb_id);

            DB::commit();

            return Output::success('Successfully removed from favourites.', $data);
        } catch (Exception $e) {
            DB::rollback();
            return Output::error($e -> getMessage());
        }
    }

    public function get_similar_movies(Request $request, $type) {
        try {
            $params = [
                "type" => $type
            ];

            $data = MovieService::get_movies($params);

            return Output::success('Successfully get a similar movies.', $data);
        } catch (Exception $e) {
            return Output::error($e -> getMessage());
        }
    }

    public function get_favourites(Request $request) {
        try {
            
            $auth_user = $request->attributes->get('user');
            $data = MovieService::get_favourites($auth_user['id']);

            return Output::success('Successfully get the data.', $data);
        } catch (Exception $e) {
            DB::rollback();
            return Output::error($e -> getMessage());
        }
    }
}
