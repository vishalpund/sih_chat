<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chats');
    }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }
    public function sendMessage(Request $request)
    {
        $message = auth()->user()->messages()->create([
            'message' => $request->message
        ]);

        broadcast(new MessageSent($message->load('user')));
        return ['status' => 'success'];
    }
}
