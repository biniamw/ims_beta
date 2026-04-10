<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Validator;
use Response;
use DB;
use App\Models\Category;

class PurchaseList implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        //$query = DB::select("SELECT customers.Name AS Supplier,categories.Name AS Category,stores.Name AS StoreName,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber,receivings.PaymentType,uoms.Name AS UOM,SUM(receivingdetails.Quantity) AS Quantity,receivingdetails.UnitCost,TRUNCATE(SUM(receivingdetails.BeforeTaxCost),2) AS BeforeTaxCost,TRUNCATE(SUM(receivingdetails.TaxAmount),2) AS Tax,TRUNCATE(SUM(receivingdetails.TotalCost),2) AS TotalCost,receivings.Status FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON receivingdetails.NewUOMId=uoms.id INNER JOIN receivings ON receivingdetails.HeaderId=receivings.id INNER JOIN stores ON receivings.StoreId=stores.id INNER JOIN customers ON receivings.CustomerId=customers.id where DATE(receivings.TransactionDate)>= '".$from."' AND DATE(receivings.TransactionDate)<='".$to."' AND receivings.StoreId IN($store) AND receivings.PaymentType IN($paymentype) AND receivings.CustomerId IN($customer) AND receivings.Status='Confirmed' GROUP BY receivingdetails.ItemId,categories.Name,regitems.Name,regitems.Code,regitems.SKUNumber,uoms.Name,receivingdetails.UnitCost,receivings.PaymentType,stores.Name,receivings.Status,customers.Name ORDER BY receivings.PaymentType ASC,customers.Name ASC");
        $query = DB::select("SELECT * FROM categories");
        //return Response::json($query);  
        return Category::all();

    }

    public function headings(): array
    {
        return [
            [' ',' ','Company name',' ',' ',' '],
            ['Name','Price','Colour','Created At','Created At','Created At']
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('storage/uploads/EmployeePicture/dummymale.jpg'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B3');

        return $drawing;
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }
}
