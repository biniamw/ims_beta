<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apptrainers extends Model
{
    use HasFactory;
    protected $table='apptrainers';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['applications_id','memberships_id','services_id','periods_id','employes_id','BeforeTotal','Tax','TotalAmount','DiscountServicePercent','DiscountServiceAmount'];
}
