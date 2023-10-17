<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CsvExport;
use App\Models\Leads;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Main admin order view page
     *
     * @return view
     */
    public function index()
    {
//        $orders = \App\Models\Order::select('orders.*')->join('users', 'users.id', '=', 'orders.user_id')->get();
        $subscriptions = Subscription::all();
        $leads = Leads::all();

        return view('/admin/orders/index')->with(compact('subscriptions', 'leads'));
    }

    /**
     * View a specific order ID.
     *
     * @param int $id
     * @return view
     */
    public function order($id)
    {
        $order = \App\Models\Order::find($id);
        if (! $order) return redirect('admin.orders')->with('error', 'Invalid order ID');
        return view('admin/orders/order')->with('order', $order);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new CsvExport(), 'csvExport.xlsx');
    }

}
