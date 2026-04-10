<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commudity extends Model
{
    use HasFactory;
    protected $table = 'commudities';
    protected $fillable = ['Zone_Id', 'Name'];
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'Zone_Id');
    }
}
