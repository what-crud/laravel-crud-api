<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms\Message;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index']]);
    }

    public function index()
    {
        return Message::orderBy('id', 'desc')->get();
    }
}
