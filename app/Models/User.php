<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class User extends Authenticatable
{



use HasFactory, Notifiable, HasRoles,HasApiTokens,SoftDeletes;



public $incrementing = false;
protected $keyType = 'string';

protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (!$model->getKey()) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        }
    });
}


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }






    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

}

