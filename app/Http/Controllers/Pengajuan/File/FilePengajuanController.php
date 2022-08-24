<?php

namespace App\Http\Controllers\Pengajuan\File;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Providers\StatusPengajuanProvider;
use Barryvdh\Debugbar\Facades\Debugbar;

class FilePengajuanController extends Controller
{
    /**
     * * Access file from URL
     *
     * @param int $id
     * @param string $filename
     * @return void
     */
    public function create($id, $filename)
    {
        if (Auth::user()->role === 'user') {
            $file = DB::table('pengajuan')
                ->join('file_detail_pengajuan', 'file_detail_pengajuan.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.user_id', '=', Auth::id())
                ->where('file_detail_pengajuan.name', '=', $filename)
                ->get();
        } else {
            $file = DB::table('pengajuan')
                ->join('file_detail_pengajuan', 'file_detail_pengajuan.id_pengajuan', 'pengajuan.id')
                ->where('current_approver', '=', Auth::user()->role)
                ->where('file_detail_pengajuan.name', '=', $filename)
                ->get();
        }

        if (count($file) === 0) {
            abort(404);
        }

        $komentar = DB::table('komentar_file_pengajuan')
            ->join('users', 'users.id', 'komentar_file_pengajuan.user_id')
            ->where('id_file_pengajuan', '=', $file[0]->id)
            ->get();

        $id_file = DB::table('file_detail_pengajuan')
            ->where('name', '=', $filename)
            ->get();

        // * Get latest approval
        $current_approver = DB::table('pengajuan')
            ->where('id', $id)
            ->get(['current_approver']);

        $status = DB::table('approval_file_pengajuan')
            ->join('users', 'users.id', 'approval_file_pengajuan.user_id')
            ->where('approval_file_pengajuan.id_file_pengajuan', '=', $id_file[0]->id)
            ->where('users.role', '=', $current_approver[0]->current_approver)
            ->get();

        $path = 'pengajuan/' . $file[0]->user_id . '/' . $id . '/' . $file[0]->jenis_file . '/' . $file[0]->name;
        $file_bin = Storage::get($path);

        $notifikasi = DB::table('notifikasi')->where('id_user', '=', Auth::id())->get();

        return view('user.detail')
            ->with('user', Auth::user())
            ->with('id', $id)
            ->with('jenis', $file[0]->skala_usaha)
            ->with('filename', $filename)
            ->with('komentar', $komentar)
            ->with('status', $status[0]->status ?? null)
            ->with('current_approver', $current_approver[0]->current_approver)
            ->with('attachment', base64_encode($file_bin))
            ->with('notifikasi', $notifikasi);
    }
    /**
     * * Add comment to document
     *
     * @param int $id
     * @param string $filename
     * @return void
     */
    public function store_komentar($id, $filename, Request $request)
    {
        $request->validate([
            'komentar' => 'required'
        ]);

        $file = DB::table('file_detail_pengajuan')
            ->where('name', '=', $filename)
            ->get();

        DB::table('komentar_file_pengajuan')
            ->insert([
                'id_file_pengajuan' => $file[0]->id,
                'user_id' => Auth::id(),
                'komentar' => $request->input('komentar'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        DB::table('notifikasi')
            ->insert([
                'id_user' => Auth::id(),
                'konten' => 'Berhasil menambahkan komentar!',
                'url' => url("detail-file/$id/$filename")
            ]);

        return back();
    }
    /**
     * * Approve File Pengajuan
     *
     * @param int $id
     * @param string $filename
     * @param Request $request
     * @return void
     */
    public function approve($id, $filename, Request $request)
    {
        // ! Disallow user to approve the document
        if (Auth::user()->role === 'user') {
            return abort(403);
        }

        $statusQuery = $request->query('status');

        $id_file = DB::table('file_detail_pengajuan')
            ->where('name', '=', $filename)
            ->get(['id']);

        if ($statusQuery === 'diterima') {
            $approval_file_availability = DB::table('approval_file_pengajuan')
                ->join('file_detail_pengajuan', 'file_detail_pengajuan.id', 'approval_file_pengajuan.id_file_pengajuan')
                ->where('name', '=', $filename)
                ->get();

            if ($approval_file_availability->count() !== 0) {
                DB::table('approval_file_pengajuan')
                    ->where('id_file_pengajuan', '=', $id_file[0]->id)
                    ->update([
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Accepted,
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('approval_file_pengajuan')
                    ->insert([
                        'id_file_pengajuan' => $id_file[0]->id,
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Accepted,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }

            $accepted_pengajuan = DB::table('pengajuan')
                ->where('id', $id)
                ->get();

            // TODO: Kirim notifikasi ke user
            DB::table('notifikasi')
                ->insert([
                    'id_user' => $accepted_pengajuan[0]->user_id,
                    'konten' => 'File Pengajuan anda sudah diterima oleh ' . Auth::user()->role . '! - ' . $accepted_pengajuan[0]->no_surat,
                    'url' => url("detail-file/$id/$filename")
                ]);

            // TODO: Kirim notifikasi ke approver
            DB::table('notifikasi')
                ->insert([
                    'id_user' => Auth::id(),
                    'konten' => 'File Pengajuan sudah berhasil diapprove! - ' . $accepted_pengajuan[0]->no_surat,
                    'url' => url("detail-file/$id/$filename")
                ]);

            return back();
        } else if ($statusQuery === 'ditolak') {
            $approval_file_availability = DB::table('approval_file_pengajuan')
                ->join('file_detail_pengajuan', 'file_detail_pengajuan.id', 'approval_file_pengajuan.id_file_pengajuan')
                ->where('name', '=', $filename)
                ->get();

            if ($approval_file_availability->count() !== 0) {
                DB::table('approval_file_pengajuan')
                    ->where('id_file_pengajuan', '=', $id_file[0]->id)
                    ->update([
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Rejected,
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('approval_file_pengajuan')
                    ->insert([
                        'id_file_pengajuan' => $id_file[0]->id,
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Rejected,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }

            $accepted_pengajuan = DB::table('pengajuan')
                ->where('id', $id)
                ->get();

            // TODO: Kirim notifikasi ke user
            DB::table('notifikasi')
                ->insert([
                    'id_user' => $accepted_pengajuan[0]->user_id,
                    'konten' => 'File Pengajuan anda sudah ditolak oleh ' . Auth::user()->role . '! - ' . $accepted_pengajuan[0]->no_surat,
                    'url' => url("detail-file/$id/$filename")
                ]);

            // TODO: Kirim notifikasi ke approver
            DB::table('notifikasi')
                ->insert([
                    'id_user' => Auth::id(),
                    'konten' => 'File Pengajuan sudah berhasil diapprove! - ' . $accepted_pengajuan[0]->no_surat,
                    'url' => url("detail-file/$id/$filename")
                ]);

            return back();
        } else {
            return abort(404);
        }
    }
}
