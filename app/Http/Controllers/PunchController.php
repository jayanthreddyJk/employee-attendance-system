<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Punch;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PunchController extends Controller
{

    public function fetchPunchesHistory(Request $request)
    {
        if ($request->ajax()) {
            $emp_id = $request->get('emp_id');
            $data = DB::table('punches')
                ->join('employees', 'punches.emp_id', '=', 'employees.emp_id')
                ->select(
                    'punches.punch_in',
                    'punches.punch_out',
                )
                ->where('punches.emp_id',$emp_id)
                ->whereDate('punches.date', now()->toDateString())
                ->orderBy('punches.punch_in')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function fetchPunchesStatus(Request $request)
    {
        if ($request->ajax()) {
            $emp_id = $request->get('emp_id');

            $data = DB::table('punchstatuses')
                ->select('punch_type',)
                ->where('emp_id',$emp_id)
                ->first();
                return response()->json([
                    'status' => $data ? $data->punch_type : 'out'
                ]);
            }
    }

    public function updatePunch(Request $request)
    {
    if ($request->ajax()) {
        $emp_id = $request->input('emp_id');

            $existingPunch = DB::table('punchstatuses')
                ->where('emp_id', $emp_id)
                ->where('punch_type', 'in')
                ->latest('created_at')
                ->first();

            if (!$existingPunch) {
                DB::table('punches')->insert([
                    'emp_id' => $emp_id,
                    'date' => now()->toDateString(),
                    'punch_in' => now()->toTimeString(),
                    'punch_out' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $exits = DB::table('punchstatuses')
                    ->where('emp_id',$emp_id)
                    ->exists();;
                if($exits){
                    DB::table('punchstatuses')
                    ->where('emp_id',$emp_id)
                    ->where('punch_type', 'out')
                    ->update([
                        'punch_type' => 'in'
                    ]);
                }else{
                    DB::table('punchstatuses')
                    ->insert([
                        'emp_id' => $emp_id,
                        'punch_type' => 'in',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
                return response()->json(['success' => true, 'message' => 'Punch In successful, Thank You!']);
            }

            if ($existingPunch) {
                DB::table('punches')
                    ->where('emp_id', $emp_id)
                    ->whereNull('punch_out')
                    ->update([
                        'punch_out' => now()->toTimeString()
                    ]);

                DB::table('punchstatuses')
                    ->where('emp_id', $emp_id)
                    ->where('punch_type', 'in')
                    ->update([
                        'punch_type' => 'out'
                    ]);

                $this->updateAttendance($emp_id, now()->toDateString());
                return response()->json(['success' => true, 'message' => 'Punch Out successful, Thank You!']);
            }
    }
}
public function updateAttendance($emp_id, $date)
{
    $punches = Punch::where('emp_id', $emp_id)
                    ->where('date', $date)
                    ->orderBy('punch_in')
                    ->get();

    if ($punches->isEmpty()) {
        return;
    }

    $totalLoginMinutes = 0;
    $breakMinutes = 0;

    for ($i = 0; $i < $punches->count(); $i++) {
        $punchIn = Carbon::parse($punches[$i]->punch_in);
        $punchOut = Carbon::parse($punches[$i]->punch_out);

        if (!is_null($punchOut)) {
            $totalLoginMinutes += $punchIn->diffInMinutes($punchOut);
        }

        if ($i < $punches->count() - 1) {
            $nextPunchIn = Carbon::parse($punches[$i + 1]->punch_in);
            $breakMinutes += $punchOut->diffInMinutes($nextPunchIn);
        }
    }

    // Convert total minutes to H:i:s format
    $totalLoginHours = sprintf('%02d:%02d:%02d', intdiv($totalLoginMinutes, 60), $totalLoginMinutes % 60, 0);
    $breakTime = sprintf('%02d:%02d:%02d', intdiv($breakMinutes, 60), $breakMinutes % 60, 0);

    $regularMinutes = 8 * 60;
    $overtimeMinutes = max(0, $totalLoginMinutes - $regularMinutes);
    $overtime = sprintf('%02d:%02d:%02d', intdiv($overtimeMinutes, 60), $overtimeMinutes % 60, 0);

    $loginTime = Carbon::parse($punches->first()->punch_in)->format('H:i:s');
    $logoutTime = !is_null($punches->last()->punch_out) ? Carbon::parse($punches->last()->punch_out)->format('H:i:s') : null;

    Attendance::updateOrCreate(
        ['emp_id' => $emp_id, 'date' => $date],
        [
            'login_time' => $loginTime,
            'logout_time' => $logoutTime,
            'total_login_hours' => $totalLoginHours,
            'break_time' => $breakTime,
            'overtime' => $overtime
        ]
    );
}


}
