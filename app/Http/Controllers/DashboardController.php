<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function create() {
        $list_pengajuan = DB::table('pengajuan')->where('user_id', '=', Auth::id())->get();
        // Debugbar::info(DB::table('pengajuan')->where('user_id', '=', Auth::id())->get());

        return view('user.dashboard')
            ->with('user', Auth::user())
            ->with('pengajuan', $list_pengajuan);
    }
}
