<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store\TransactionProduct;

class TransactionProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index']]);
    }

    private $m = TransactionProduct::class;
    private $pk = 'id';

    public function index()
    {
        return TransactionProduct
            ::with('product.section')
            ->with('transaction.customer')
            ->with('transaction.status')
            ->orderBy('id', 'desc')
            ->get();
    }
}
