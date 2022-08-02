<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    public function create()
    {
        $notifikasi = DB::table('notifikasi')->where('id_user', '=', Auth::id());

        return response()->json($notifikasi);
    }

    public function store(Request $request)
    {
        DB::table('notifikasi')
            ->insert([
                'id_user' => Auth::id(),
                'konten' => $request->input('konten'),
                'url' => $request->input('url')
            ]);

        return response()->json([
            'message' => 'Sucessfully created new notification!',
            'input' => [
                'id_user' => Auth::id(),
                'konten' => $request->input('konten'),
                'url' => $request->input('url')
            ]
        ]);
    }
}
