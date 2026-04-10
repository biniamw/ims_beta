<?php

namespace App\Imports;
use App\Models\Regitem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Response;

class ImportItem implements ToModel,WithStartRow,WithValidation,WithMultipleSheets
{
    use SkipsFailures;
    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '0' => 'required|unique:regitems,Name',
            '1' => 'required|unique:regitems,Code',
            '17' => 'nullable|unique:regitems,PartNumber',
            '19' => 'nullable|unique:regitems,SKUNumber'
        ];
    }

    public function sheets(): array
    {
        return [
            2 => $this,
        ];
    }

    public function model(array $row)
    {
        return new Regitem([
            'Name' => $row[0],
            'Code' => $row[1],
            'MeasurementId' => $row[2],
            'CategoryId' => $row[3],
            'RetailerPrice' => $row[4],
            'WholesellerPrice' => $row[5],
            'wholeSellerMinAmount' => $row[6],
            'wholeSellerMaxAmount' => $row[7],
            'MinimumStock' => $row[8],
            'MaxCost' => $row[9],
            'minCost' => $row[10],
            'averageCost' => $row[11],
            'pmretail' => $row[12],
            'pmwholesale' => $row[13],
            'TaxTypeId' => $row[14],
            'RequireSerialNumber' => $row[15],
            'RequireExpireDate' => $row[16],
            'PartNumber' => $row[17],
            'Description' => $row[18],
            'SKUNumber' => $row[19],
            'oldSKUNumber' => $row[20],
            'BarcodeImage' => $row[21],
            'BarcodeType' => $row[22],
            'oldBarcodeType' => $row[23],
            'ActiveStatus' => $row[24],
            'IsDeleted' => $row[25],
            'Type' => $row[26],
            'itemGroup' => $row[27],
            'LowStock' => $row[28],
            'DeadStockPrice' => $row[29],
            'dsmaxcost' => $row[30],
            'dsmaxcosteditable' => $row[31],
            'itemImage' => $row[32],
            'imageName' => $row[33],
            'path' => $row[34],
        ]);
    }
}
