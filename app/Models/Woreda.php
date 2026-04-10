<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Zone;

class Woreda extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'woredas';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['Type','Woreda_Name','Wh_name','Symbol','zone_id','phone','email','created_by','updated_by','description', 'status'];

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'woredas', 'zone_id', 'id');
    }
}
