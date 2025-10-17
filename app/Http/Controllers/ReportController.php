<?php

namespace App\Http\Controllers;

use App\Models\Pemetaan;
use App\Models\Role;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Halaman Laporan UMKM (Admin Only)
     */
    public function showReportPage(Request $request)
    {
        $this->authorizeAdmin();

        // Ambil parameter filter dari request
        $nama    = $request->input('nama');
        $tanggal = $request->input('tanggal');
        $bulan   = $request->input('bulan');
        $tahun   = $request->input('tahun');

        // Query dasar
        $query = Pemetaan::query();

        // === FILTERS ===
        if (!empty($nama)) {
            $query->where('name', 'like', '%' . $nama . '%');
        }

        if (!empty($tanggal)) {
            $query->whereDate('created_at', $tanggal);
        }

        if (!empty($bulan)) {
            $query->whereMonth('created_at', $bulan);
        }

        if (!empty($tahun)) {
            $query->whereYear('created_at', $tahun);
        }

        // === Data untuk web (paginate) ===
        $pemetaans = (clone $query)
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->appends($request->query()); // menjaga filter di pagination

        // === Data untuk cetak (semua data hasil filter) ===
        $pemetaansAll = (clone $query)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.reports.umkm-report', compact('pemetaans', 'pemetaansAll'));
    }

    /**
     * Check if user is admin
     */
    private function authorizeAdmin()
    {
        if (auth()->user()->role_id !== Role::ROLE_ADMIN) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses fitur ini.');
        }
    }
}
