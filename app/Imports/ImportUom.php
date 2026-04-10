<?php

namespace App\Imports;
use App\Models\uom;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Response;

class ImportUom implements ToModel,WithStartRow,WithValidation,WithMultipleSheets
{
    use SkipsFailures;
    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '0' => 'unique:uoms,Name',
            '1' => 'required',
            '2' => 'required'
        ];
    }

    public function sheets(): array
    {
        return [
            1 => $this,
        ];
    }

    public function model(array $row)
    {
        return new uom([
            'Name' => $row[0],
            'ActiveStatus' => $row[1],
            'IsDeleted' => $row[2],
        ]);
    }
}
