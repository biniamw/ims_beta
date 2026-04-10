<?php

namespace App\Imports;
use App\Models\customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Response;

class ImportCustomer implements ToModel,WithStartRow,WithValidation,WithMultipleSheets
{
    use SkipsFailures;
    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '0' => 'required|unique:customers,Name',
            '1' => 'required|unique:customers,Code',
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
        return new customer([
            'Name' => $row[0],
            'Code' => $row[1],
            'CustomerCategory' => $row[2],
            'DefaultPrice' => $row[3],
            'TinNumber' => $row[4],
            'VatNumber' => $row[5],
            'MRCNumber' => $row[6],
            'VatType' => $row[7],
            'Witholding' => $row[8],
            'PhoneNumber' => $row[9],
            'OfficePhone' => $row[10],
            'EmailAddress' => $row[11],
            'Address' => $row[12],
            'Website' => $row[13],
            'Country' => $row[14],
            'Memo' => $row[15],
            'ActiveStatus' => $row[16],
            'Reason' => $row[17],
            'IsDeleted' => $row[18],
            'CreditLimitPeriod' => $row[19],
            'CreditLimit' => $row[20],
            'salesamount' => $row[21],
            'IsAllowedCreditSales' => $row[22],
            'CreditSalesLimitStart' => $row[23],
            'CreditSalesLimitEnd' => $row[24],
            'CreditSalesLimitFlag' => $row[25],
            'CreditSalesLimitDay' => $row[26],
            'CreditSalesAdditionPercentage' => $row[27],
            'SettleAllOutstanding' => $row[28],
        ]);
    }
}
