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
        $notifikasi = DB::table('notifikasi')->where('id_user', '=', Auth::id())->get();

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

    public function destroy(Request $request)
    {
        $id_notifikasi = $request->query('id');

        if ($id_notifikasi === null) {
            $data = DB::table('notifikasi')
                ->where('id_user', '=', Auth::id())
                ->get();
            DB::table('notifikasi')
                ->where('id_user', '=', Auth::id())
                ->delete();
            return response()->json([
                'message' => 'Sucessfully deleted all notification below',
                'data' => $data
            ]);
        } else {
            $data = DB::table('notifikasi')
                ->where('id_user', '=', Auth::id())
                ->where('id', '=', $id_notifikasi)
                ->get();
            DB::table('notifikasi')
                ->where('id_user', '=', Auth::id())
                ->where('id', '=', $id_notifikasi)
                ->delete();
            return response()->json([
                'message' => 'Sucessfully deleted the notification below',
                'data' => $data
            ]);
        }
    }
}
