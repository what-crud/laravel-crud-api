<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompaniesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    private $m = Company::class;
    private $pk = 'id';

    public function index()
    {
        return Company
            ::with('companyType')
            ->with('streetPrefix')
            ->orderBy('common_name', 'asc')
            ->get();
    }
    public function show($id)
    {
        $companyInfo = Company
            ::where('id', $id)
            ->with('companyType')
            ->with('streetPrefix')
            ->with('files')
            ->with('positions', 'positions.person')
            ->with('positions.company')
            ->with(
                'comments.companyCommentType',
                'comments.user'
            )
            ->with(
                ['comments' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }],
                'comments.companyCommentType',
                'comments.user'
            )
            ->first();
        return $companyInfo;
    }
}
