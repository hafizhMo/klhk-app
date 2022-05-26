<?php

namespace App\Http\Controllers\Pengajuan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TemporaryPengajuanController extends Controller {
    public function redirect(Request $request) {
        // TODO: Insert the data to database
        // ! This only hardcoded redirect from tipe pengajuan input
        
        $request->validate([
            'tipe' => 'required'
        ]);

        // ! This still not working
        if (!$request->has('tipe')) {
            Session::flash('error', 'Tipe usaha kosong!');
            return redirect('/user/create-file');
        }
        // ? This works though
        if ($request->input('tipe') === 'kecil') {
            return redirect('/user/upload-file/low');
        } else if ($request->input('tipe') === 'menengah') {
            return redirect('/user/upload-file/middle');
        }
    }
}