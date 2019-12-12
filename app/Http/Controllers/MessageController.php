<?php

namespace App\Http\Controllers;

use App\Message;
use App\Room;
use App\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function get(Room $room, User $user)
    {
        return Message::where('room_id', $room->id)
            ->with('user')->get();
    }
}
