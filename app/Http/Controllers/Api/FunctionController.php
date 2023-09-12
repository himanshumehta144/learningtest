<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\ApiResponse\ApiResponse;

class FunctionController extends Controller
{
    use ApiResponse;

    public $perPage;
    public $response;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->perPage = 10;
        $this->response = array();
    }

    /**
     * userList
     *
     * @param  mixed $request
     * @return void
     */
    public function userList(Request $request)
    {
        $data = User::paginate($this->perPage);

        $this->response['results'] = array();
        $this->response['pagination'] = array();

        $this->response = UserResource::collection($data);
        return $this->sendResponse($this->response, __('Success'), Response::HTTP_OK);
    }
}
