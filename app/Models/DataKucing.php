<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DataKucing extends Model
{
    protected $table = 'data_kucing';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'nama_kucing',
        'ras',
        'umur',
        'jenis_kelamin',
        'warna',
        'ciri_khusus',
        'alamat_pemilik',
        'nomor_hp',
        'qr_code',
        'foto',
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
}