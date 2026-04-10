<?php

namespace App\Imports;
use App\Models\store;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Response;

class ImportStore implements ToModel,WithStartRow,WithValidation,WithMultipleSheets
{
    use SkipsFailures;
    public function startRow(): int
    {
        return 2;
    } 

    public function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'unique:stores,Name',
            '2' => 'required',
            '3' => 'required'
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
        return new store([
            'type' => $row[0],
            'Name' => $row[1],
            'Place' => $row[2],
            'ActiveStatus' => $row[3],
            'CreatedBy' => $row[4],
            'CreatedDate' => $row[5],
            'IsDeleted' => $row[6],
        ]);
    }

}
