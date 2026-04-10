<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Region extends Model
{
    use HasFactory;
    /* The database table used by the model.
     *
     * @var string
     */
    protected $table = 'regions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['Rgn_Name', 'Rgn_Number', 'created_by', 'updated_by', 'description', 'status'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
