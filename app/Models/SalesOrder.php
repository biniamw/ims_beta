<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesOrder extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_orders';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'docno',
        'reference',
        'customer_id',
        'user_id',
        'store_id',
        'preparedate',
        'orderdate',
        'deliverydate',
        'paymenterm',
        'subtotal',
        'tax',
        'grandtotal',
        'memo',
        'withold',
        'vat',
        'netpay',
        'istaxable',
        'status',
        'oldstatus',
        'contactperson',
        'address',
        'phone',
        'pricevalidity',
        'expiredate',
        'name',
        'path',
        'purchaseorderno',
    ];

    /**
     * Get the customer associated with the sales order.
     *
     * @return BelongsTo
     */
    public function customers(): BelongsTo
    {
        return $this->belongsTo(customer::class, 'customer_id');
    }

    /**
     * Get the user associated with the sales order.
     *
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the store associated with the sales order.
     *
     * @return BelongsTo
     */
    public function stores(): BelongsTo
    {
        return $this->belongsTo(store::class, 'store_id');
    }

    /**
     * Get the actions associated with the sales order.
     *
     * @return HasMany
     */
    public function actions(): HasMany
    {
        return $this->hasMany(actions::class, 'pageid');
    }

    /**
     * Get the actions with user details associated with the sales order.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActions()
    {
        return $this->actions()
            ->where('pagename', 'salesorders')
            ->join('users', 'actions.user_id', '=', 'users.id')
            ->orderByDesc('actions.id')
            ->get(['actions.*', 'users.FullName as user']);
    }

    /**
     * Get the items associated with the sales order.
     *
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(
            Regitem::class,              // Related model
            'sales_order_items',         // Pivot table
            'sales_order_id',            // Foreign key on the pivot table for the current model
            'regitem_id'                 // Foreign key on the pivot table for the related model
        )->withTimestamps();             // Include timestamps in the pivot table
    }
}
