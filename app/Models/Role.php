<?php

namespace App\Models;
use App\Models\RoleUser;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'slug',
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
     * Relation users
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'role_user',
            'role_id',
            'user_id'
        )
        ->using(RoleUser::class)
        ->withPivot('id')
        ->withTimestamps();
    }
}