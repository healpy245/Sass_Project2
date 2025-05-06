<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;



class Company extends Model
{
    use SoftDeletes;





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


    protected $fillable = ['name'];


    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
