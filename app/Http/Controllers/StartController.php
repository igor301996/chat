<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Events\PrivateMessage;
use Illuminate\Http\Request;

class StartController extends Controller
{
    public function index()
    {
        return view('start');
    }

    public function sendMessage(Request $request)
    {
        event(new NewMessage($request->input('message')));
    }

    public function sendPrivateMessage(Request $request)
    {
        PrivateMessage::dispatch($request->all());

        return $request->all();
    }
}
