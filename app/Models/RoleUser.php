<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_user';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'role_id',
    ];

    /**
     * Boot UUID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relation user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}