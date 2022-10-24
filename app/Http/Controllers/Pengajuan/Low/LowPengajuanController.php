<?php

namespace App\Http\Controllers\Pengajuan\Low;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\UserRoleProvider;
use App\Http\Controllers\Controller;
use App\Providers\JenisFilePengajuanProvider;
use App\Providers\StatusPengajuanProvider;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Storage;

class LowPengajuanController extends Controller
{
    /**
     * * View Lower Pengajuan by Id
     *
     * @param int $id
     * @return void
     */
    public function create($id)
    {
        if (Auth::user()->role === 'user') {
            $pengajuan = DB::table('pengajuan')
                ->where('id', '=', $id)
                ->where('user_id', '=', Auth::id())
                ->get();
        } else {
            $pengajuan = DB::table('pengajuan')
                ->where('id', '=', $id)
                ->get();
        }


        // ! Prevent url param brute force
        $available = $pengajuan->count();

        if ($available < 1) {
            return abort(404);
        }
        // ! ===============================

        // ! Return 404 if not Proposal for Low

        if ($pengajuan[0]->skala_usaha !== 'kecil') {
            return abort(404);
        }

        // ! ===============================

        $file = DB::table('file_detail_pengajuan')
            ->where('id_pengajuan', '=', $id)
            ->get();

        $status = DB::table('pengajuan')
            ->where('id', '=', $id)
            ->get(['status'])[0]
            ->status;

        $approval_pengajuan = DB::table('approval_pengajuan')
            ->where('id_pengajuan', '=', $id)
            ->get();

        $file_approval_binary = null;
        $already_approve = null;
        if ($approval_pengajuan->count() > 0) {
            $file_approval = DB::table('file_approval_pengajuan')
                ->where('id_approval_pengajuan', $approval_pengajuan[0]->id)
                ->get();

            if ($file_approval->count() > 0) {
                $file_path = 'approval_pengajuan/' . $id . '/' . $file_approval[0]->name;
                if (Storage::exists($file_path)) {
                    $file_approval_binary = Storage::get($file_path);
                }
                // TODO: Blocking approval after being approved before
                // ! Bad query
                // $already_approve = DB::table('approval_pengajuan')
                //     ->join('users', 'users.id', 'approval_pengajuan.user_id')
                //     ->where('users.role', '=', Auth::user()->role)
                //     ->get()
                //     ->count();
            }
        }

        $current_approver_pengajuan = DB::table('pengajuan')
            ->where('id', '=', $id)
            ->get(['current_approver'])[0]
            ->current_approver;

        $approval_file_pengajuan = DB::table('approval_file_pengajuan AS approval')
            ->select([
                'approval.*',
                'file_pengajuan.*',
            ])
            ->join('file_detail_pengajuan AS file_pengajuan', 'file_pengajuan.id', 'approval.id_file_pengajuan')
            ->join('users AS user', 'user.id', 'approval.user_id')
            ->where('file_pengajuan.id_pengajuan', '=', $id)
            ->where('user.role', '=', $current_approver_pengajuan)
            ->orWhere('user.role', '=', Auth::user()->role)
            ->get();

        $notifikasi = DB::table('notifikasi')->where('id_user', '=', Auth::id())->get();

        return view('uploads.low')
            ->with('user', Auth::user())
            ->with('detail_pengajuan', $status !== 'ditolak' ? $file : [])
            ->with('approval_detail_pengajuan', Auth::user()->role === 'user' ? ($status === 'pending' ? [] : $approval_file_pengajuan) : $approval_file_pengajuan)
            ->with('status', $status)
            ->with('pengajuan', $pengajuan[0])
            ->with('komentar_pengajuan', count($approval_pengajuan) > 0 ? $approval_pengajuan[count($approval_pengajuan) - 1]->komentar : null)
            // ->with('approved', $already_approve ?? $already_approve > 0 ? true : false)
            ->with('notifikasi', $notifikasi)
            ->with('file_approval', base64_encode($file_approval_binary))
            ->with('page_id', $id);
    }
    /**
     * * Store new Pengajuan by Lower Bussiness
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function store(Request $request, $id)
    {
        /**
         * ? Storage Path for Pengajuan
         */
        $storagePathPengajuan = 'pengajuan/' . Auth::id() . '/' . $id . '/';
        /**
         * ? Basename for New uploaded Filename
         *
         * * [Format] = <User ID>_<Pengajuan ID>_<Year>-<Month>-<Day>-<Hour>-<Minute>-<Second>.<File Extension>
         */
        $base_filename = Auth::id() . '_' . $id . '_' . Carbon::now()->format('Y-m-d-H-i-s');

        $pengajuan = DB::table('pengajuan')
            ->where('id', '=', $id)
            ->where('user_id', '=', Auth::id())
            ->get();

        // ! Prevent url param brute force
        $available = $pengajuan->count();

        if ($available < 1) {
            return abort(404);
        }
        // ! ===============================

        // ! Return 404 if not Proposal for Low

        if ($pengajuan[0]->skala_usaha !== 'kecil') {
            return abort(404);
        }

        // ! ===============================

        // ? Upload Surat Permohonan
        if ($request->hasFile(JenisFilePengajuanProvider::SuratPermohonan)) {
            $file = $request->file(JenisFilePengajuanProvider::SuratPermohonan);
            $filename = JenisFilePengajuanProvider::SuratPermohonan . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::SuratPermohonan, $filename);

            $surat_permohonan = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::SuratPermohonan)
                ->get();

            $surat_permohonan_availability = $surat_permohonan
                ->count();

            if ($surat_permohonan_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::SuratPermohonan,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->where('jenis_file', '=', JenisFilePengajuanProvider::SuratPermohonan)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);

                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::SuratPermohonan . '/' . $surat_permohonan[0]->name);
            }
        }

        // ? Upload NIB
        if ($request->hasFile(JenisFilePengajuanProvider::NIB)) {
            $file = $request->file(JenisFilePengajuanProvider::NIB);
            $filename = JenisFilePengajuanProvider::NIB . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::NIB, $filename);

            $nib = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::NIB)
                ->get();

            $nib_availability = $nib
                ->count();

            if ($nib_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::NIB,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->where('jenis_file', '=', JenisFilePengajuanProvider::NIB)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);

                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::NIB . '/' . $nib[0]->name);
            }
        }

        // ? Upload SPPL
        if ($request->hasFile(JenisFilePengajuanProvider::SPPL)) {
            $file = $request->file(JenisFilePengajuanProvider::SPPL);
            $filename = JenisFilePengajuanProvider::SPPL . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::SPPL, $filename);

            $sppl = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::SPPL)
                ->get();

            $sppl_availability = $sppl
                ->count();

            if ($sppl_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::SPPL,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->where('jenis_file', '=', JenisFilePengajuanProvider::SPPL)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);

                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::SPPL . '/' . $sppl[0]->name);
            }
        }

        // ? Upload Surat Pernyataan Pengolahan
        if ($request->hasFile(JenisFilePengajuanProvider::SuratPernyataan)) {
            $file = $request->file(JenisFilePengajuanProvider::SuratPernyataan);
            $filename = JenisFilePengajuanProvider::SuratPernyataan . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::SuratPernyataan, $filename);

            $surat_pernyataan = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::SuratPernyataan)
                ->get();

            $surat_pernyataan_availability = $surat_pernyataan
                ->count();

            if ($surat_pernyataan_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::SuratPernyataan,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->where('jenis_file', '=', JenisFilePengajuanProvider::SuratPernyataan)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);

                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::SuratPernyataan . '/' . $surat_pernyataan[0]->name);
            }
        }

        // ? Upload Pernyataan OSS
        if ($request->hasFile(JenisFilePengajuanProvider::PenyataanMandiriOSS)) {
            $file = $request->file(JenisFilePengajuanProvider::PenyataanMandiriOSS);
            $filename = JenisFilePengajuanProvider::PenyataanMandiriOSS . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . '/' . JenisFilePengajuanProvider::PenyataanMandiriOSS, $filename);

            $pernyataan_oss = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::PenyataanMandiriOSS)
                ->get();

            $pernyataan_oss_availability = $pernyataan_oss
                ->count();

            if ($pernyataan_oss_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::PenyataanMandiriOSS,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->where('jenis_file', '=', JenisFilePengajuanProvider::PenyataanMandiriOSS)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);

                Storage::delete($storagePathPengajuan . '/' . JenisFilePengajuanProvider::PenyataanMandiriOSS . '/' . $pernyataan_oss[0]->name);
            }
        }

        $file = DB::table('file_detail_pengajuan')
            ->where('id_pengajuan', '=', $id)
            ->get();

        $status = DB::table('pengajuan')
            ->where('id', '=', $id)
            ->get(['status']);

        DB::table('notifikasi')
            ->insert([
                'id_user' => Auth::id(),
                'konten' => 'File pengajuan berhasil diunggah!',
                'url' => url("user/upload-file/low/$id"),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        return back();
    }
    /**
     * * Send new Pengajuan by Lower Bussiness to Approver
     *
     * @param int $id
     * @return void
     */
    public function send($id)
    {
        $file = DB::table('file_detail_pengajuan')
            ->where('id_pengajuan', '=', $id)
            ->get();

        // ===================
        // ! Check required file has already uploaded
        //  ==================
        $file_pengajuan = $file
            ->count();

        if ($file_pengajuan !== JenisFilePengajuanProvider::JumlahJenisPengajuanBawah) {
            return back()
                ->with('error', 'Ada file pengajuan yang belum diupload, silahkan dicek kembali');
        }
        // ====================
        $get_current_approver = DB::table('pengajuan')
            ->where('id', '=', $id)
            ->get(['current_approver'])[0]
            ->current_approver;

        if ($get_current_approver === null) {
            DB::table('pengajuan')
                ->where('id', '=', $id)
                ->update([
                    'status' => StatusPengajuanProvider::Pending,
                    'current_approver' => UserRoleProvider::ApproverQueue[0]
                ]);
        } else {
            $indexCurrentApprover = array_search($get_current_approver, UserRoleProvider::ApproverQueue);
            DB::table('pengajuan')
                ->where('id', '=', $id)
                ->update([
                    'status' => StatusPengajuanProvider::Pending,
                    'current_approver' => UserRoleProvider::ApproverQueue[$indexCurrentApprover]
                ]);
        }

        DB::table('notifikasi')
            ->insert([
                'id_user' => Auth::id(),
                'konten' => 'Pengajuan berhasil dikirim!',
                'url' => url("user/upload-file/low/$id"),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        return back();
    }
    /**
     * * Approve pengajuan by Lower Business
     *
     * ! Copypasta from MiddlePengajuanController.php
     *
     * @param int $id
     * @param Request $request
     * @return void
     */
    public function approve($id, Request $request)
    {
        // ! Disallow user to approve the document
        if (Auth::user()->role === 'user') {
            return abort(403);
        }

        // ! Check approved document count
        $checkFilePengajuan = DB::table('file_detail_pengajuan')
            ->where('id_pengajuan', '=', $id)
            ->get();

        $checkFilePengajuanIds = array();
        foreach ($checkFilePengajuan as $val) {
            array_push($checkFilePengajuanIds, $val->id);
        }

        $checkApprovedFileCount = DB::table('approval_file_pengajuan')
            ->whereIn('id_file_pengajuan', $checkFilePengajuanIds)
            ->get()
            ->count();

        if ($checkApprovedFileCount < JenisFilePengajuanProvider::JumlahJenisPengajuanBawah || $checkApprovedFileCount > JenisFilePengajuanProvider::JumlahJenisPengajuanBawah) {
            return back()
                ->with('error', 'Masih ada file yang belum di-approve!');
        }

        // ! ================================

        $statusQuery = $request->query('status');

        if ($statusQuery === 'diterima') {
            if (Auth::user()->role === 'kadin') {
                // ? Upload Surat Persetujan dari Kadin
                // TODO: Error pas diupload sama kadin
                $file = $request->file('surat_persetujuan');
                /**
                 * ? Storage Path for Approval Pengajuan
                 */
                $storagePathApprovalPengajuan = 'approval_pengajuan/' . $id . '/';
                /**
                 * ? Basename for New uploaded Filename
                 *
                 * * [Format] = <User ID>_<Pengajuan ID>_<Year>-<Month>-<Day>-<Hour>-<Minute>-<Second>.<File Extension>
                 */
                $base_filename = Auth::id() . '_' . $id . '_' . Carbon::now()->format('Y-m-d-H-i-s');

                $filename = $base_filename . "." . $file->extension();

                $checkRejectedFile = DB::table('file_detail_pengajuan')
                    ->join('approval_file_pengajuan', 'approval_file_pengajuan.id_file_pengajuan', 'file_detail_pengajuan.id')
                    ->where('file_detail_pengajuan.id_pengajuan', '=', $id)
                    ->where('approval_file_pengajuan.status', '=', StatusPengajuanProvider::Rejected)
                    ->get()
                    ->count();

                if ($checkRejectedFile > 0) {
                    return back()
                        ->with('error', 'Cek kembali file yang di-approve! Masih ada file yang ditolak!');
                }

                if (!$request->hasFile('surat_persetujuan')) {
                    return back()
                        ->with('error', 'Butuh surat persetujuan!');
                }

                $file->storeAs($storagePathApprovalPengajuan, $filename);
            }

            $approval_pengajuan = DB::table('approval_pengajuan')
                ->where('id_pengajuan', '=', $id)
                ->get();

            $approval_pengajuan_availability = $approval_pengajuan
                ->count();

            if ($approval_pengajuan_availability > 0) {
                DB::table('approval_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->update([
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Accepted,
                        'komentar' => $request->input('komentar'),
                        'updated_at' => Carbon::now()
                    ]);
                if (Auth::user()->role === 'kadin') {
                    $file_approval_pengajuan = DB::table('file_approval_pengajuan')
                        ->where('id_approval_pengajuan', '=', $approval_pengajuan[0]->id)
                        ->get();

                    if ($file_approval_pengajuan->count() === 0) {
                        DB::table('file_approval_pengajuan')
                            ->insert([
                                'id_approval_pengajuan' => $approval_pengajuan[0]->id,
                                'name' => $filename,
                                'type' => $file->extension(),
                                'size' => $file->getSize(),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                    } else {
                        DB::table('file_approval_pengajuan')
                            ->update([
                                'id_approval_pengajuan' => $approval_pengajuan[0]->id,
                                'name' => $filename,
                                'type' => $file->extension(),
                                'size' => $file->getSize(),
                                'updated_at' => Carbon::now()
                            ]);
                        Storage::delete($storagePathApprovalPengajuan . $file_approval_pengajuan[0]->name);
                    }
                }
            } else {
                DB::table('approval_pengajuan')
                    ->insert([
                        'id_pengajuan' => $id,
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Accepted,
                        'komentar' => $request->input('komentar'),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }

            // * Automatic send proposal to next approver based on queue
            $indexCurrentApprover = array_search(Auth::user()->role, UserRoleProvider::ApproverQueue);

            if ($indexCurrentApprover === count(UserRoleProvider::ApproverQueue) - 1) {
                DB::table('pengajuan')
                    ->where('id', $id)
                    ->update([
                        'status' => StatusPengajuanProvider::Accepted,
                        'current_approver' => null
                    ]);

                return back();
            }

            $nextApprover = UserRoleProvider::ApproverQueue[$indexCurrentApprover + 1];

            DB::table('pengajuan')
                ->where('id', $id)
                ->update([
                    'status' => StatusPengajuanProvider::Pending,
                    'current_approver' => $nextApprover
                ]);

            $accepted_pengajuan = DB::table('pengajuan')
                ->where('id', $id)
                ->get();

            // TODO: Kirim notifikasi ke user
            DB::table('notifikasi')
                ->insert([
                    'id_user' => $accepted_pengajuan[0]->user_id,
                    'konten' => 'Pengajuan anda sudah diterima oleh ' . Auth::user()->role . '! - ' . $accepted_pengajuan[0]->no_surat,
                    'url' => url("user/upload-file/low/$id"),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            // TODO: Kirim notifikasi ke approver
            DB::table('notifikasi')
                ->insert([
                    'id_user' => Auth::id(),
                    'konten' => 'Pengajuan sudah berhasil diapprove! - ' . $accepted_pengajuan[0]->no_surat,
                    'url' => url("user/upload-file/low/$id"),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            return back();
        } else if ($statusQuery === 'ditolak') {
            $file = $request->file('surat_penolakan');
            /**
             * ? Storage Path for Approval Pengajuan
             */
            $storagePathApprovalPengajuan = 'approval_pengajuan/' . $id . '/';
            /**
             * ? Basename for New uploaded Filename
             *
             * * [Format] = <User ID>_<Pengajuan ID>_<Year>-<Month>-<Day>-<Hour>-<Minute>-<Second>.<File Extension>
             */
            $base_filename = Auth::id() . '_' . $id . '_' . Carbon::now()->format('Y-m-d-H-i-s');

            $filename = $base_filename . "." . $file->extension();

            $checkRejectedFile = DB::table('file_detail_pengajuan')
                ->join('approval_file_pengajuan', 'approval_file_pengajuan.id_file_pengajuan', 'file_detail_pengajuan.id')
                ->where('file_detail_pengajuan.id_pengajuan', '=', $id)
                ->where('approval_file_pengajuan.status', '=', StatusPengajuanProvider::Rejected)
                ->get()
                ->count();

            if ($checkRejectedFile === 0) {
                return back()
                    ->with('error', 'Cek kembali file yang di-approve! Harus ada satu file yang ditolak!');
            }

            if (!$request->hasFile('surat_penolakan')) {
                return back()
                    ->with('error', 'Butuh surat penolakan!');
            }

            $file->storeAs($storagePathApprovalPengajuan, $filename);

            $approval_pengajuan = DB::table('approval_pengajuan')
                ->where('id_pengajuan', '=', $id)
                ->get();

            $approval_pengajuan_availability = $approval_pengajuan->count();

            if ($approval_pengajuan_availability > 0) {
                // // TODO: Waktu tolak pertama kali, ini gada, bikin error!
                $file_approval_pengajuan = DB::table('file_approval_pengajuan')
                    ->where('id_approval_pengajuan', '=', $approval_pengajuan[0]->id)
                    ->get();

                DB::table('approval_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->update([
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Rejected,
                        'updated_at' => Carbon::now()
                    ]);
                DB::table('pengajuan')
                    ->where('id', $id)
                    ->update([
                        'status' => StatusPengajuanProvider::Rejected
                    ]);
                DB::table('file_approval_pengajuan')
                    ->update([
                        'id_approval_pengajuan' => $approval_pengajuan[0]->id,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);

                if ($file_approval_pengajuan->count() > 0) {
                    Storage::delete($storagePathApprovalPengajuan . $file_approval_pengajuan[0]->name);
                }
            } else {
                DB::table('approval_pengajuan')
                    ->insert([
                        'id_pengajuan' => $id,
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Rejected,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                DB::table('pengajuan')
                    ->where('id', $id)
                    ->update([
                        'status' => StatusPengajuanProvider::Rejected
                    ]);

                $id_approval_pengajuan = DB::table('approval_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->get();

                DB::table('file_approval_pengajuan')
                    ->insert([
                        'id_approval_pengajuan' => $id_approval_pengajuan[0]->id,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }

            $rejected_pengajuan = DB::table('pengajuan')
                ->where('id', $id)
                ->get();

            // TODO: Kirim notifikasi ke user
            DB::table('notifikasi')
                ->insert([
                    'id_user' => $rejected_pengajuan[0]->user_id,
                    'konten' => 'Pengajuan anda sudah ditolak oleh ' . Auth::user()->role . '! - ' . $rejected_pengajuan[0]->no_surat,
                    'url' => url("user/upload-file/middle/$id"),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            // TODO: Kirim notifikasi ke approver
            DB::table('notifikasi')
                ->insert([
                    'id_user' => Auth::id(),
                    'konten' => 'Pengajuan sudah berhasil diapprove! - ' . $rejected_pengajuan[0]->no_surat,
                    'url' => url("user/upload-file/middle/$id"),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            return back();
        } else {
            return abort(404);
        }
    }
}
