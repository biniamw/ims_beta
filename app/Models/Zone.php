<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Woreda;

class Zone extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'zones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['Rgn_Id', 'Zone_Name', 'created_by', 'updated_by', 'description', 'status'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'Rgn_Id');
    }
    
    public function woredas()
    {
        return $this->belongsToMany(Woreda::class, 'woredas', 'zone_id', 'zone_id')->withTimestamps();
    }
}
