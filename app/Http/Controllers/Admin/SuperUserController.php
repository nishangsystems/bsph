<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Charge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperUserController extends Controller
{
    /**
     * Get daily platform charges payment statistics for the specified day (otherwise all days) of this month or specified month
     */
    function platform_charge_daily_report(Request $request) {
        $data['title'] = "Daily Platform Charges Payment Report";
        if(($month = $request->month) == null){
            $month = now()->format('m-Y');
        }
        $year_id = $request->year_id != null ? $request->year_id : $this->current_accademic_year;
        $data['report'] = Charge::where(['year_id'=>$year_id])->whereMonth('created_at', $month)
            ->select([DB::raw("MONTH(created_at) as _month"), DB::raw("DAY(created_at) as _day"), DB::raw("SUM(CASE WHEN amount != 0 THEN 1 ELSE 0 END) as amounts"), DB::raw("COUNT(*) as count"), DB::raw("SUM(amount) as amount_received"), 'created_at'])
            ->groupBy('_day')->distinct()->orderBy('created_at', 'DESC')->get()->each(function($record){
                $record->day = now()->parse($record->created_at)->format('l M dS');
            });

        return view('admin.superuser.plcreports', $data);
    }
}
