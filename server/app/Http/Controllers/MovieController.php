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
    // begin transaction
    public function __construct() {
        DB::beginTransaction();
    }

    // movies list
    public function get_movies(Request $request) {
        try {
            // taking from request
            $page = trim($request -> input('page'));
            $search = trim($request -> input('search'));
            $type = trim($request -> input('type'));

            // creating params
            $params = [
                "page" => $page,
                "search" => $search,
                "type" => $type
            ];

            // calling service file by passing params
            $data = MovieService::get_movies($params);

            // returning response with data
            return Output::success('Successfully get the data.', $data);
        } catch (Exception $e) {
            // if err
            // rollback
            DB::rollback();

            // return error
            return Output::error($e -> getMessage());
        }
    }

    // get movie by imdb id
    public function get_movie_by_imdb_id(Request $request, $imdb_id) {
        try {
            // calling service file
            $data = MovieService::get_movie_by_imdb_id($imdb_id);

            // returning response
            return Output::success('Successfully get a movie detail.', $data);
        } catch (Exception $e) {
            // if err

            // return err response
            return Output::error($e -> getMessage());
        }
    }

    // add to fav
    public function add_to_favourite(Request $request, $imdb_id) {
        try {
            // taking request
            $title = trim($request -> input('title'));
            $year = trim($request -> input('year'));
            $type = trim($request -> input('type'));
            $poster = trim($request -> input('poster'));

            // creating params
            $params = [
                "title" => $title,
                "year" => $year,
                "type" => $type,
                "poster" => $poster
            ];

            // taking user detail from request
            $auth_user = $request->attributes->get('user');

            // calling service file
            $data = MovieService::add_to_favourite($request, $auth_user['id'], $imdb_id, $params);

            // if true, commint
            DB::commit();

            // return response
            return Output::success('Successfully added to favourites.', $data);
        } catch (Exception $e) {
            // if err

            // rollback
            DB::rollback();

            // return err response
            return Output::error($e -> getMessage());
        }
    }

    // delete from favourites
    public function delete_from_favourites(Request $request, $imdb_id) {
        try {
            // taking user from request
            $auth_user = $request->attributes->get('user');

            // calling serivce file
            $data = MovieService::delete_from_favourites($request, $auth_user['id'], $imdb_id);

            // if true, commint
            DB::commit();

            // return response
            return Output::success('Successfully removed from favourites.', $data);
        } catch (Exception $e) {
            // if err

            // rollback
            DB::rollback();

            // return err response
            return Output::error($e -> getMessage());
        }
    }

    // get similar movies
    public function get_similar_movies(Request $request, $type) {
        try {
            // creating params
            $params = [
                "type" => $type
            ];

            // calling service file
            $data = MovieService::get_movies($params);

            // return response
            return Output::success('Successfully get a similar movies.', $data);
        } catch (Exception $e) {
            // return err response
            return Output::error($e -> getMessage());
        }
    }

    // ger favourites
    public function get_favourites(Request $request) {
        try {
            // getting user from request
            $auth_user = $request->attributes->get('user');

            // calling service file
            $data = MovieService::get_favourites($auth_user['id']);

            // return response
            return Output::success('Successfully get the data.', $data);
        } catch (Exception $e) {
            // if err
            DB::rollback();

            // return err response
            return Output::error($e -> getMessage());
        }
    }
}
