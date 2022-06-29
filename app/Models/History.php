<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class History extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public static function getDataOneWeek()
    {
        return DB::table('histories')
            ->select(DB::raw('DATE(created_at) as date,count(id) as jumlah'))
            ->groupBy('date')
            ->havingBetween('date', [Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])
            ->get();
    }
}
