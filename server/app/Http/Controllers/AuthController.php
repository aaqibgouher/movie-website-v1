<?php

namespace App\Http\Controllers;

use Exception;
use App\Utilities\Output;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // beginning a transaction
    public function __construct() {
        DB::beginTransaction();
    }

    // register
    public function register(Request $request) {
        try {
            // taking input from request
            $name = trim($request -> input('name'));
            $email = trim($request -> input('email'));
            $password = trim($request -> input('password'));
            $confirm_password = trim($request -> input('confirm_password'));

            // if password != confirm password
            if($password && $password !== $confirm_password) throw new Exception('Password and Confirm password is not same.');

            // calling register in service file
            $data = AuthService::register($name, $email, $password);

            // if everything is ok, commiting
            DB::commit();

            // returning api response
            return Output::success('Successfully registered', $data);
        } catch (Exception $e) {
            // if err
            // rollback
            DB::rollBack();

            // return error response
            return Output::error($e -> getMessage());
        }
    }

    public function login(Request $request) {
        try {
            $email = trim($request -> input('email'));
            $password = trim($request -> input('password'));

            $data = AuthService::login($email, $password);

            DB::commit();
            return Output::success('Successfully login', $data);
        } catch (Exception $e) {
            DB::rollback();
            return Output::error($e -> getMessage());
        }
    }

    public function logout(Request $request) {
        try {
            $data = [];
            $auth_user = $request->attributes->get('user');
            
            AuthService::logout($auth_user['id'], $auth_user['token']);

            DB::commit();
            return Output::success('Successfully logout', $data);
        } catch (Exception $e) {
            DB::rollback();
            return Output::error($e -> getMessage());
        }
    }
}
