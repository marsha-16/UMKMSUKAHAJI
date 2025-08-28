<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Pemetaan;

class SearchController extends Controller
{
    public function index(Request $request){
        $keyword = $request->input('q');
        $users = $pemetaans = collect();

        if ($keyword) {
            // Cari di tabel users
            $users = User::where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->get();

            // Cari di tabel pemetaans
            $pemetaansQuery = Pemetaan::query()
                            ->where(function($q) use ($keyword) {
                                $q->where('nik', 'like', "%{$keyword}%")
                                  ->orWhere('name', 'like', "%{$keyword}%")
                                  ->orWhere('address', 'like', "%{$keyword}%");
                            });

            $pemetaans = $pemetaansQuery->get();
        }       
        return view('search.results', compact('users', 'pemetaans', 'keyword'));
    }
}