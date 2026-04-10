<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FullName',
        'email',
        'username',
        'phone',
        'password',
        'AlternatePhone',
        'Address',
        'Nationality',
        'Gender',
        'Status',
        'usertype',
        'ChangePass',
        'IsPurchaser',
        'accstatus',
        'empid',
        'Common',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function stores()
    {
        return $this->belongsToMany(stores::class, 'storeassignments');
    }

    public function storeassignments()
    {
        return $this->hasMany(storeassignment::class);
    }

    public function companymrcs()
    {
        return $this->belongsToMany(companymrc::class, 'mrcassignments','UserId','MRCId')->where('Type',1)->where('companymrcs.ActiveStatus','Active')->where('companymrcs.IsDeleted',1)->withTimestamps();
    }

    public function storesmrc()
    {
        return $this->belongsToMany(storemrc::class)->withTimestamps();
    }
}
