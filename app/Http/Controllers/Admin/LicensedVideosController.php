<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CsvExport;
use App\Exports\VideoOrdersExport;
use App\Http\Controllers\Controller;
use App\Models\LicensedVideo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LicensedVideosController extends Controller
{
    public function videoOrders() {
        $licenses = LicensedVideo::with('user')->with('video')->orderBy('created_at', 'desc')->get();

        return view('/admin/video-orders/index')->with('licenses', $licenses);
    }

    public function videoOrdersExport() {
        return Excel::download(new VideoOrdersExport(), 'videoOrdersExport.xlsx');
    }
}
