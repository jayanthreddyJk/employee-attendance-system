<?php

namespace App\Exports;

use App\Models\Punch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PunchExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Punch::select("emp_id", "date", "punch_in","punch_out")->get();
    }
    public function headings(): array
    {
        return ["Employee ID", "Date", "Punch In","Punch Out"];
    }
}
