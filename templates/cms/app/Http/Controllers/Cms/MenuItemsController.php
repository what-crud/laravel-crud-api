<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms\MenuItem;

class MenuItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index']]);
    }

    public function index()
    {
        return MenuItem::orderBy('order', 'asc')
            ->get();
    }
}
