<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengajuanController extends Controller
{
    public function create()
    {
        return view('user.create')
            ->with('user', Auth::user());
    }

    public function store(Request $request)
    {
        if (!$request->has('tipe')) {
            return back()
                ->with('error', 'Tipe usaha kosong!');
        }

        $validator = Validator::make($request->all(), [
            'nama_pengajuan' => 'required',
            'perihal' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->with('error', 'Ada field yang kosong!');
        }

        $total_today_pengajuan_count = Pengajuan::all()
            ->where('created_at', '=', Carbon::now())->count() + 1;

        $pengajuan = new Pengajuan;
        $pengajuan->nama_pengajuan = $request->input('nama_pengajuan');
        $pengajuan->no_surat = '552/' . $total_today_pengajuan_count . '/123.4/' . Carbon::now()->format('Y');
        $pengajuan->perihal = $request->input('perihal');
        $pengajuan->skala_usaha = $request->input('tipe');
        $pengajuan->save();

        // ? Redirect to input detail pengajuan (kecil/menengah)
        if ($request->input('tipe') === 'kecil') {
            return redirect('/user/upload-file/low/' . $pengajuan->id)
                ->with('user', Auth::user());
        } else if ($request->input('tipe') === 'menengah') {
            return redirect('/user/upload-file/middle/' . $pengajuan->id)
                ->with('user', Auth::user());
        }
    }

    public function create_low($id) {
        $pengajuan = Pengajuan::all()
            ->where('id', '=', $id)
            ->where('user_id', '=', Auth::id());
        // ! Prevent url param brute force
        $available = $pengajuan->count();

        if ($available < 1) {
            return abort(404);
        }
        // ! ===============================

        return view('uploads.low')
            ->with('user', Auth::user())
            ->with('detail_pengajuan', $pengajuan);
    }

    public function store_low(Request $request) {
        Debugbar::info($request);

        return view('uploads.low')
            ->with('user', Auth::user());
    }

    public function create_middle($id) {
        $pengajuan = Pengajuan::all()
            ->where('id', '=', $id)
            ->where('user_id', '=', Auth::id());
        // ! Prevent url param brute force
        $available = $pengajuan->count();

        if ($available < 1) {
            return abort(404);
        }
        // ! ===============================

        return view('uploads.middle')
            ->with('user', Auth::user())
            ->with('detail_pengajuan', $pengajuan);
    }

    public function store_middle(Request $request) {
        Debugbar::info($request);

        return view('uploads.middle')
            ->with('user', Auth::user());
    }
}
