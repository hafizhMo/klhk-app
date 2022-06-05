<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            return back()->with('error', 'Tipe usaha kosong!');
        }

        $validator = Validator::make($request->all(), [
            'nama_pengajuan' => 'required',
            'perihal' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Ada field yang kosong!');
        }

        $total_today_pengajuan_count = Pengajuan::all()->where('created_at', '=', Carbon::now())->count() + 1;

        $pengajuan = new Pengajuan;
        $pengajuan->nama_pengajuan = $request->input('nama_pengajuan');
        $pengajuan->no_surat = '552/' . $total_today_pengajuan_count . '/123.4/' . Carbon::now()->format('Y');
        $pengajuan->perihal = $request->input('perihal');
        $pengajuan->skala_usaha = $request->input('tipe');
        $pengajuan->save();

        // ? Redirect to input detail pengajuan (kecil/menengah)
        if ($request->input('tipe') === 'kecil') {
            return redirect('/user/upload-file/low')->with('user', Auth::user());
        } else if ($request->input('tipe') === 'menengah') {
            return redirect('/user/upload-file/middle')->with('user', Auth::user());
        }
    }
}
