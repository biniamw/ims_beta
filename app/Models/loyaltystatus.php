<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loyaltystatus extends Model
{
    use HasFactory;
    protected $table='loyaltystatuses';
    public $primarykey='id';
    protected $fillable = ['LoyalityStatus','MinDay', 'MaxDay','Discount'];
}
