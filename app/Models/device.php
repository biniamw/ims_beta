<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class device extends Model
{
    use HasFactory;
    protected $table='devices';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['branches_id','DeviceId','DeviceName','IpAddress','Port','TimeZone','SyncMode','RegistrationDevice','AttendanceDevice',
    'Username','Password','Description','CreatedBy','LastEditedBy','LastEditedDate','Status'];
}
