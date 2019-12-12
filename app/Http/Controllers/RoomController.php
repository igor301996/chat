<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $user->rooms()->get();

        return response()->json($user, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rooms = Room::where('name', $request->input('name'))->first();
        if (!$rooms){
           $room = Room::create([
               'name' => $request->input('name')
            ]);

            return response()->json($room, 201, [], JSON_UNESCAPED_UNICODE);
        }

        return [
            'status' => 'error',
            'msg' => 'Комната с таким именем существует: '. $request->input('name'),
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return response()->json($room, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $room->update([
            'name' =>$request->input('name')
        ]);

        return response()->json($room, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json([
            'status' => 'ok',
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
