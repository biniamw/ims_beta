<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicepaymenthistory extends Model
{
    use HasFactory;
    protected $table='servicepaymenthistories';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['applications_id','paymenthistorygyms_id','services_id','periods_id','BeforeTotal','Tax','TotalAmount','DiscountServicePercent','DiscountServiceAmount'];
}
