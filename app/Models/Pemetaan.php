<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pemetaan extends Model
{
    protected $guarded = [];

    public function getStatusLabelAttribute() // status_label
    {
        return match ($this->status) {
            'process' => 'Sedang Diproses',
            'approve' => 'Diterima',
            'rejected' => 'Ditolak',
            default => 'Tidak Diketahui',
        };
    }

    public function getReportDateLabelAttribute()
    {
        // kalau ada kolom report_date di DB
        if ($this->report_date) {
            return Carbon::parse($this->report_date)
                ->timezone('Asia/Jakarta')
                ->translatedFormat('d F Y H:i');
        }

        // fallback: pakai created_at
        return Carbon::parse($this->created_at)
            ->timezone('Asia/Jakarta')
            ->translatedFormat('d F Y H:i');
    }

    public function getStatusColorAttribute() //status_color
    {
        return match ($this->status) {
            'process' => 'warning',
            'approve' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }

    public function umkm()
    {
        return $this->belongsTo(UMKM::class);
    }
}
