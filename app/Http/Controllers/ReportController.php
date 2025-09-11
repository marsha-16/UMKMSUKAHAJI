<?php

namespace App\Http\Controllers;

use App\Models\Pemetaan;
use App\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show report page - Admin Only
     */
    public function showReportPage()
{
    $this->authorizeAdmin();

    // Untuk web (paginate)
    $pemetaans = Pemetaan::orderBy('created_at', 'desc')->paginate(5);

    // Untuk print (semua data)
    $pemetaansAll = Pemetaan::orderBy('created_at', 'desc')->get();

    return view('pages.reports.umkm-report', compact('pemetaans', 'pemetaansAll'));
}



//     public function printAll()
// {
//     $this->authorizeAdmin();

//     // Ambil semua data
//     $pemetaansAll = Pemetaan::orderBy('created_at', 'desc')->get();

//     // Agar Blade tidak error, buat $pemetaans kosong
//     $pemetaans = collect();

//     return view('pages.reports.umkm-report', compact('pemetaans', 'pemetaansAll'));
// }



    /**
     * Get data for report via AJAX - Admin Only
     */
    public function getReportData(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'status_filter' => 'nullable|in:all,process,approve,rejected',
            'date_from'     => 'nullable|date',
            'date_to'       => 'nullable|date|after_or_equal:date_from',
            'include_stats' => 'boolean'
        ]);

        // Query dasar dengan relasi user
        $query = Pemetaan::with('user');

        // Filter status
        if (!empty($validated['status_filter']) && $validated['status_filter'] !== 'all') {
            $query->where('status', $validated['status_filter']);
        }

        // Filter tanggal
        if (!empty($validated['date_from'])) {
            $query->whereDate('created_at', '>=', $validated['date_from']);
        }
        if (!empty($validated['date_to'])) {
            $query->whereDate('created_at', '<=', $validated['date_to']);
        }

        // Ambil data utama
        $pemetaans = $query->orderByDesc('created_at')->get();

        // Statistik (jika diminta)
        $stats = $validated['include_stats'] ?? false ? $this->generateStatistics(clone $query) : [];

        return response()->json([
            'success' => true,
            'data'    => [
                'pemetaans'      => $pemetaans->map(fn($item) => $this->transformPemetaan($item)),
                'stats'          => $stats,
                'filters'        => [
                    'status'    => $validated['status_filter'] ?? 'all',
                    'date_from' => $validated['date_from'] ?? null,
                    'date_to'   => $validated['date_to'] ?? null,
                ],
                'generated_at'   => now()->format('d/m/Y H:i:s'),
                'generated_by'   => auth()->user()->name,
                'total_records'  => $pemetaans->count()
            ]
        ]);
    }

    /**
     * Generate statistics for report
     */
    private function generateStatistics($query)
    {
        $total    = $query->count();
        $approved = (clone $query)->where('status', 'approve')->count();
        $process  = (clone $query)->where('status', 'process')->count();
        $rejected = (clone $query)->where('status', 'rejected')->count();

        return [
            'total'          => $total,
            'approved'       => $approved,
            'process'        => $process,
            'rejected'       => $rejected,
            'approval_rate'  => $total > 0 ? round(($approved / $total) * 100, 2) : 0,
            'business_types' => $this->getGroupedStats(clone $query, 'business'),
            'platforms'      => $this->getGroupedStats(clone $query, 'promotion'),
        ];
    }

    /**
     * Get grouped stats (helper for business and promotion)
     */
    private function getGroupedStats($query, $field)
    {
        return $query->selectRaw("$field, COUNT(*) as count")
                     ->groupBy($field)
                     ->orderByDesc('count')
                     ->get();
    }

    /**
     * Transform Pemetaan data for response
     */
    private function transformPemetaan($item)
    {
        return [
            'id'           => $item->id,
            'name'         => $item->name ?? 'N/A',
            'nik'          => $item->nik,
            'address'      => $item->address,
            'phone'        => $item->phone,
            'business'     => $item->business,
            'marketing'    => $item->marketing,
            'promotion'    => $item->promotion,
            'document'     => $item->document,
            'created_at'   => $item->created_at->format('d/m/Y H:i'),
            'status'       => $item->status,
            'status_label' => $this->getStatusLabel($item->status),
            // 'has_photo'    => !empty($item->photo_proof)
        ];
    }

    /**
     * Get status label
     */
    private function getStatusLabel($status)
    {
        return match ($status) {
            'approve'  => 'Disetujui',
            'process'  => 'Sedang Diproses',
            'rejected' => 'Ditolak',
            default    => 'Tidak Diketahui',
        };
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
