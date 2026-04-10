<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commodity_ending_detail extends Model
{
    use HasFactory;
    protected $table='commodity_ending_details';
    public $primarykey='id';
    public $timestamps=true; 
    protected $fillable=['commodity_endings_id', 'supplier_id', 'grn_number', 'cert_number',
    'production_number', 'stores_id', 'location_id', 'woredas_id', 'commodity_type', 'grade', 
    'process_type', 'crop_year', 'uoms_id', 'no_of_bag', 'bag_weight', 'total_kg', 'net_kg', 'feresula', 
    'unit_cost', 'total_cost', 'variance_shortage', 'variance_overage', 'disc_shortage_bag', 'disc_overage_bag',
    'disc_shortage_kg','disc_overage_kg' ,'Remark'];
}
