<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class bank extends Model
{
    use HasFactory;
    protected $table = 'banks';
    public $primarykey = 'id';
    public $timestamps = true; 
    public $fillable = ['BankName','Description','Status','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'];

    public function banksdet(){
        return $this->belongsToMany(bankdetail::class,'bankdetails','banks_id','banks_id')->withTimestamps();
    }

    const CACHE_KEY = 'bank_data_all';

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
        $bank = self::updateOrCreate($attributes, $values);
        // Cache is automatically cleared via model events
        return $bank;
    }

    public static function upsertWithCache(array $values, array $uniqueBy, array $update = null)
    {
        $result = self::upsert($values, $uniqueBy, $update);
        // Cache is automatically cleared via model events
        return $result;
    }
}
