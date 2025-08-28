<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function getReportDateLabelAttribute() // report_date_label
    {
        return \Carbon\Carbon::parse($this->report_date)->format('d M Y H:i:s');
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
