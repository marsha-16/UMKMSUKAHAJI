<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UMKM extends Model
{
    protected $table = 'u_m_k_m_s';

    protected $fillable = [
        'name',
        'address',
    ];
    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pemetaans()
    {
        return $this->hasMany(Pemetaan::class);
    }
}
