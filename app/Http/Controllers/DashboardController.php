<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function create() {
        if (Auth::user()->role === 'user') {
            $list_pengajuan = DB::table('pengajuan')->where('user_id', '=', Auth::id())->get();

            return view('user.dashboard')
                ->with('user', Auth::user())
                ->with('pengajuan', $list_pengajuan);
        } else {
            $list_pengajuan = DB::table('pengajuan')->where('current_approver', '=', Auth::user()->role)->get();

            return view('user.dashboard')
                ->with('user', Auth::user())
                ->with('pengajuan', $list_pengajuan);
        }
    }
}
