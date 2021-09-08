<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function memberReportPerMount($daterange)
    {
        if ($daterange != '') {
            $date  = explode('+', $daterange);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end   = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59'; 
        }

        $member_ajax =  User::select('id','name')->whereBetween('created_at', [$start, $end])->get();
        return response()->json($member_ajax);
    }

}
