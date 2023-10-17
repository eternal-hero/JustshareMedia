<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransactionAttempt;
use Illuminate\Http\Request;

class FailedTransactionsController extends Controller
{
    public function index() {
        $data = [
            'items' => TransactionAttempt::where('status', TransactionAttempt::STATUS_FAILED)->orderBy('created_at', 'desc')->get()
        ];

        return view('admin/failed-transactions/index')->with('data', $data);
    }
}
