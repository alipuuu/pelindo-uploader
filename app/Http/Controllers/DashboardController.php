<?php

namespace App\Http\Controllers;

use App\Models\DashboardModel;
use App\Models\UploadModel;
use App\Models\ServerModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
      public function __construct()
    {
        $this->DashboardModel = new DashboardModel();
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::count();
        $server = ServerModel::count();
        $upload = UploadModel::count();

        $tanggal=['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
        $uploadtanggal = UploadModel::where('created_at', $tanggal)->count();
        $uploadtanggal = [];
        foreach ($tanggal as $key => $valuetanggal) {
            $uploadtanggal[] = UploadModel::where(DB::raw("DATE_FORMAT(created_at, '%d')"),$valuetanggal)->count();
        }

        $bulan = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $uploadbulan =  UploadModel::where('created_at', $bulan)->count();
        $uploadbulan = [];
        foreach ($bulan as $key => $valuebulan) {
            $uploadbulan[] = UploadModel::where(DB::raw("DATE_FORMAT(created_at, '%m')"),$valuebulan)->count();
        }

        $grafik = [
            'tanggal'       => json_encode($tanggal,JSON_NUMERIC_CHECK),
            'uploadtanggal' => json_encode($uploadtanggal,JSON_NUMERIC_CHECK),
            'bulan'         => json_encode($bulan,JSON_NUMERIC_CHECK),
            'uploadbulan'   => json_encode($uploadbulan,JSON_NUMERIC_CHECK),
            'users'         => json_encode($users,JSON_NUMERIC_CHECK),
            'server'        => json_encode($server,JSON_NUMERIC_CHECK),
            'upload'        => json_encode($upload,JSON_NUMERIC_CHECK),

        ];
    	return view('v_dashboard')->with($grafik);
    }
}
