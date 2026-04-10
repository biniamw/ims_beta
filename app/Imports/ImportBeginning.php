<?php

namespace App\Imports;
use App\Models\beginingdetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Response;

class ImportBeginning implements ToModel,WithStartRow,WithValidation,WithMultipleSheets
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
            '1' => 'required',
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
        return new beginingdetail([
            'HeaderId' => $row[0],
            'ItemId' => $row[1],
            'Quantity' => $row[2],
            'UnitCost' => $row[3],
            'BeforeTaxCost' => $row[4],
            'TaxAmount' => $row[5],
            'TotalCost' => $row[6],
            'StoreId' => $row[7],
            'Date' => $row[8],
            'RequireSerialNumber' => $row[9],
            'RequireExpireDate' => $row[10],
            'ItemType' => $row[11],
            'TransactionType' => $row[12],
            'SerialNumberFlag' => $row[13],
        ]);
    }

}
