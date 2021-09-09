<?php

namespace App\Http\Controllers\API;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function memberReportPerMount($daterange)
    {
        if ($daterange != '') {
            $date  = explode('+', $daterange);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end   = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59'; 
        }

        $member =  User::select([
            DB::raw('count(id) as count'),
            DB::raw('DATE(created_at) as day')
        ])->groupBy('day')
        ->whereBetWeen('created_at',[$start, $end])->get();
        
        $data = [];
        foreach ($member as $value) {
            $data[] = [
                'day' => date('d-m-Y', strtotime($value->day)),
                'count' => $value->count
            ];
        }
        return $data;
    }

}
