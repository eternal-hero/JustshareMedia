<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogsController extends Controller
{
    /**
     * Logs landing page.
     *
     * @return void
     */
    public function index()
    {
        $logs = \Logger\Laravel\Models\Log::all()->sortByDesc('created_at');
        return view('admin/logs/index')->with('logs', $logs);
    }

    /**
     * Load a log by ID
     *
     * @param integer $logID
     * @return void
     */
    public function get(int $logID)
    {
        $log = \Logger\Laravel\Models\Log::find($logID);
        return print_r($log);
    }
}
