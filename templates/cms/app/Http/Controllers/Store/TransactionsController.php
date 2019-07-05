<?php

namespace App\Http\Controllers\Store;

use App\Models\Store\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
    }

    private $m = Transaction::class;
    private $pk = 'id';

    public function index()
    {
        return Transaction
            ::with('customer')
            ->with('status')
            ->orderBy('id', 'desc')
            ->get();
    }
    public function show($id)
    {
        $transactionInfo = Transaction
            ::where('id', $id)
            ->with('transactionProducts.product.section')
            ->first();
        return $transactionInfo;
    }
}
