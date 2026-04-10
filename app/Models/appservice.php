<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appservice extends Model
{
    use HasFactory;
    protected $table='appservices';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['applications_id','services_id','periods_id','devices_id','BeforeTotal','Tax','TotalAmount','DiscountServicePercent','DiscountServiceAmount'];
}
