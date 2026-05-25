<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lookupref extends Model
{
    use HasFactory;
    protected $table='lookuprefs';
    public $primarykey='id';
    protected $fillable = ['Type','LookupName', 'Status','Description'];
}
