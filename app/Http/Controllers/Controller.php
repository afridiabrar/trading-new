<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        try {
            Helpers::currency_load();
            \View::share('headerCategories', \App\Model\Category::active()->all());
        } catch (\Exception $exception) {

        }
    }

    public function respond($data = [], $errors = [] , $status = 200 , $message = '')
    {
        return response()->json(
            [
                'data' => $data,
                'errors' => $errors,
                'status' => $status,
                'message' => $message
            ], $status);
    }

    public function unauthorized()
    {
        return response()->json(
            [
                'data' => [],
                'errors' => ["Unauthenticated."],
                'status' => 401,
                'message' => "Unauthenticated."
            ], 401);
    }
}
