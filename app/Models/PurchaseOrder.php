<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchaseorders';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'purchaseordertype',
        'purchasevaulation_id',
        'customers_id',
        'porderno',
        'date',
        'memo',
        'type',
        'istaxable',
        'subtotal',
        'tax',
        'grandtotal',
        'withold',
        'netpay',
        'status',
        'oldstatus',
        'orderdate',
        'deliverydate',
        'store',
        'paymenterm',
        'commudtytype',
        'commudtysource',
        'commudtystatus',
        'isreviewed',
    ];

    /**
     * Get the woredas associated with the purchase order.
     *
     * @return BelongsToMany
     */
    public function woredas(): BelongsToMany
    {
        return $this->belongsToMany(Woreda::class, 'purchaseordersdetails', 'purchaseorder_id', 'itemid')->withTimestamps();
    }

    /**
     * Get the actions associated with the purchase order.
     *
     * @return HasMany
     */
    public function actions(): HasMany
    {
        return $this->hasMany(actions::class, 'pageid');
    }

    /**
     * Get the items associated with the purchase order.
     *
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Regitem::class, 'purchaseordersdetails', 'purchaseorder_id', 'itemid')->withTimestamps();
    }
}