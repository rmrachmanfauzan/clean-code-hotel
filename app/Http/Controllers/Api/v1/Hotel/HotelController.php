<?php

namespace App\Http\Controllers\Api\v1\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Part;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HotelController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    
    /**
    * Return full list of hotels
    * @return Response
    */

    public function index(Request $request)
    {
        $limit = ($request->limit ? : 10);
        $sort = ($request->sort ? : "desc");
        $sortBy = ($request->sortBy ? : "created_at");
        
        $hotels = Hotel::filter($request->all())->orderBy($sortBy, $sort)->paginate($limit)->appends($request->input());
        
        return $this->successResponse($hotels,"pagination");
    }


    /**
     * Create one new hotels
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = Hotel::getValidationRules();
        $this->validate($request, $rules);
        $hotel = Hotel::create($request->all());
        return $this->successResponse($hotel, Response::HTTP_CREATED);
    }


    /**
     * Show a specific hotel
     * @param Hotel $hotel
     * @return Response
     */
    public function show($hotel)
    {
        $hotel = Hotel::findOrFail($hotel);
        return $this->successResponse($hotel);
    }


    /**
     * Update hotel information
     * @param Request $request
     * @param $hotel
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $hotel)
    {
        $rules = Hotel::getValidationRules();
        
        $this->validate($request, $rules);
        $hotel = Hotel::findOrFail($hotel);

        $hotel->fill($request->all());
        if($hotel->isClean()){
            return $this->errorResponse("Atleast one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $hotel->save();
        return $this->successResponse($hotel);
    }


    /**
     * Delete hotel information
     * @param $hotel
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($hotel)
    {
        $hotel = Hotel::findOrFail($hotel);
        $hotel->delete();
        return $this->successResponse($hotel);
    }
}
