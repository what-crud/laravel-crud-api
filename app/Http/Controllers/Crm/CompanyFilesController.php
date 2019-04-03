<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\CompanyFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyFilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    private $m = CompanyFile::class;
    private $pk = 'id';

    public function index()
    {
        return CompanyFile
            ::orderBy('company_id', 'asc')
            ->with('company')
            ->get();
    }
}
