<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CatCredit extends Model
{
    protected $table = 'cat_credits';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'credits'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addCredit($qty = 1)
    {
        $this->increment('credits', $qty);
    }

    public function useCredit($qty = 1)
    {
        if ($this->credits < $qty) {
            return false;
        }

        $this->decrement('credits', $qty);

        return true;
    }
}