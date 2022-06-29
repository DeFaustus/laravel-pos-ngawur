<?php

namespace App\Http\Controllers;

use App\Models\History;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index()
    {
        $jumlahHariIni = History::where(DB::raw('DATE(created_at)'), Carbon::now()->toDateString())->count();
        $mingguIni = History::whereBetween(DB::raw('DATE(created_at)'), [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $periode = CarbonPeriod::create(Carbon::now()->startOfWeek()->toDateString(), Carbon::now()->endOfWeek()->toDateString());
        $labels = [];
        foreach ($periode as $key => $value) {
            $labels[] = $value->toDateString();
        }
        return view('dashboard.dashboard-index', [
            'title'         => 'Dashboard',
            'hariIni'       => $jumlahHariIni,
            'mingguIni'     => $mingguIni,
            'penMingguIni'  => History::getDataOneWeek(),
            'labels'        => $labels
        ]);
    }
}
