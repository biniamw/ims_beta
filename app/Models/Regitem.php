<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Regitem extends Model
{
    use HasFactory;
    protected $table = 'regitems';
    public $primarykey = 'id';
    public $timestamps = true;
    protected $fillable = ['Name','Code','MeasurementId','CategoryId','RetailerPrice','WholesellerPrice',
        'wholeSellerMinAmount','wholeSellerMaxAmount','MinimumStock','MaxCost','minCost','averageCost',
        'pmretail','pmwholesale','TaxTypeId','price_type','min_price_bt','min_price_at','default_price_bt',
        'default_price_at','max_price_bt','max_price_at','RequireSerialNumber','RequireExpireDate',
        'PartNumber','lot_description','cartoon_size','Description','SKUNumber','oldSKUNumber',
        'BarcodeImage','BarcodeType','oldBarcodeType','item_code_mode','item_type','old_item_code',
        'ActiveStatus','IsDeleted','created_at','updated_at','Type','itemGroup','LowStock','DeadStockPrice',
        'dsmaxcost','dsmaxcosteditable','itemImage','imageName','path','standard_factor'
    ];
               
    public function Salesitem(){
        return $this->belongsTo(Regitem::class,'ItemId','id');
    }

    public function items(){
        return $this->hasMany(Salesitem::class,'id','id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'CategoryId', 'id',);
    }

    public function additemlog(){
        return $this->hasMany(Itemlog::class);
    }

    public function itemtransaction(){
        return $this->hasMany(transaction::class,'','ItemId');
    }

    const CACHE_KEY = 'products_all';

    protected static function boot()
    {
        parent::boot();

        // Clear cache when a record is created
        static::created(function ($model) {
            static::clearCache();
        });

        // Clear cache when a record is updated
        static::updated(function ($model) {
            static::clearCache();
        });

        // Clear cache when a record is deleted
        static::deleted(function ($model) {
            static::clearCache();
        });

        // Clear cache when multiple records are updated (for updateOrCreate)
        static::saved(function ($model) {
            static::clearCache();
        });

        // Clear cache when bulk operations happen
        static::saving(function ($model) {
            static::clearCache();
        });
    }

    public static function clearCache()
    {
        Cache::forget(self::CACHE_KEY);
        // If you have search caches, clear them too
        // Cache::forget('inventory_search_*');
        
        \Log::info('cache cleared');
    }

    public static function getCachedItems()
    {
        return Cache::remember(self::CACHE_KEY, 3600, function () {
            return self::all();
        });
    }

    public static function refreshCache()
    {
        self::clearCache();
        return self::getCachedItems();
    }

    public static function updateOrCreateWithCache(array $attributes, array $values = [])
    {
        $item = self::updateOrCreate($attributes, $values);
        // Cache is automatically cleared via model events
        return $item;
    }

    public static function upsertWithCache(array $values, array $uniqueBy, array $update = null)
    {
        $result = self::upsert($values, $uniqueBy, $update);
        // Cache is automatically cleared via model events
        return $result;
    }

}
