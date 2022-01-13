<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
    * Return full list of users
    * @return Response
    */
    public function index(Request $request)
    {
        $limit = ($request->limit ? : 10);
        $sort = ($request->sort ? : "desc");
        $sortBy = ($request->sortBy ? : "created_at");
        
        $users = User::filter($request->all())->orderBy($sortBy, $sort)->paginate($limit)->appends($request->input());
        
        return $this->successResponse($users,"pagination");
    }


    /**
     * Create one new users
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = User::getValidationRules();

        $this->validate($request, $rules);
        $user = User::create($request->all());

        return $this->successResponse($user, Response::HTTP_CREATED);
    }


    /**
     * Show a specific user
     * @param User $user
     * @return Response
     */
    public function show($user)
    {
        $user = User::findOrFail($user);
        return $this->successResponse($user);
    }


    /**
     * Update user information
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $user)
    {
        $rules = User::getValidationRules();
        
        $this->validate($request, $rules);
        $user = User::findOrFail($user);
        $user->fill($request->all());
        if($user->isClean()){
            return $this->errorResponse("Atleast one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
       
        $user->save();
        return $this->successResponse($user);
    }

    /**
     * Delete user information
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($user)
    {
        $user = User::findOrFail($user);
        $user->delete();
        return $this->successResponse($user);
    }
}
