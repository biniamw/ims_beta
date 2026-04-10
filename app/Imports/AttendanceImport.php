<?php

namespace App\Imports;

use App\Models\attendance_import_log;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Response;
use Carbon\Carbon;

class AttendanceImport implements ToModel,WithStartRow,WithValidation,WithMultipleSheets
{
    use SkipsFailures;
    public function startRow(): int
    {
        return 4;
    }

    public function rules(): array
    {
        return [
            '0' => 'required',
            '3' => 'required',
        ];
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function model(array $row)
    {
        return new attendance_import_log([
            'empid' => 1,
            'Name' => $row[3],
            'DateTime' => $row[0],
            'deviceid' =>1,
            'DeviceCode' =>1,
            'similarity1' => $row[2],
            'ImportType' =>2,
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);
    }
}
