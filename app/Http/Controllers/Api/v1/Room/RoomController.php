<?php

namespace App\Http\Controllers\Api\v1\Room;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends Controller
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
    * Return full list of rooms
    * @return Response
    */
    public function index(Request $request)
    {
        $limit = ($request->limit ? : 10);
        $sort = ($request->sort ? : "desc");
        $sortBy = ($request->sortBy ? : "created_at");
        $rooms = Room::filter($request->all())->orderBy($sortBy, $sort)->paginate($limit)->appends($request->input());
        
        return $this->successResponse($rooms,"pagination");
    }


    /**
     * Create one new rooms
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = Room::getValidationRules();

        $this->validate($request, $rules);

        $room = Room::create($request->all());

        return $this->successResponse($room, Response::HTTP_CREATED);
    }


    /**
     * Show a specific room
     * @param Room $room
     * @return Response
     */
    public function show($room)
    {
        $room = Room::findOrFail($room);
        return $this->successResponse($room);
    }


    /**
     * Update room information
     * @param Request $request
     * @param $room
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $room)
    {
        $rules = Room::getValidationRules();
        
        $this->validate($request, $rules);
        $room = Room::findOrFail($room);
        $room->fill($request->all());
        if($room->isClean()){
            return $this->errorResponse("Atleast one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
       
        $room->save();
        return $this->successResponse($room);
    }


    /**
     * Delete room information
     * @param $room
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($room)
    {
        $room = Room::findOrFail($room);
        $room->delete();
        return $this->successResponse($room);
    }
}
