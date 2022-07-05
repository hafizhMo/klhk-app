<?php

namespace App\Http\Controllers\Pengajuan\Middle;

use Session;
use Carbon\Carbon;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\UserRoleProvider;
use App\Http\Controllers\Controller;
use App\Providers\JenisFilePengajuanProvider;
use App\Providers\StatusPengajuanProvider;
use Debugbar;
use Illuminate\Support\Facades\Auth;


class MiddlePengajuanController extends Controller
{
    /**
     * * View for Pengajuan for Middle Bussiness
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

        // ! Return 404 if not Proposal for Middle

        if ($pengajuan[0]->skala_usaha !== 'menengah') {
            return abort(404);
        }

        // ! ===============================

        $file = DB::table('file_detail_pengajuan')
            ->where('id_pengajuan', '=', $id)
            ->get();

        $status = DB::table('pengajuan')
            ->where('id', '=', $id)
            ->get(['status']);

        return view('uploads.middle')
            ->with('user', Auth::user())
            ->with('detail_pengajuan', $file)
            ->with('status', $status[0]->status)
            ->with('page_id', $id);
    }
    /**
     * * Create New Pengajuan for Middle Bussiness
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

        // ! Return 404 if not Proposal for Middle

        if ($pengajuan[0]->skala_usaha !== 'menengah') {
            return abort(404);
        }

        // ! ===============================

        // ? Upload NIB
        if ($request->hasFile(JenisFilePengajuanProvider::NIB)) {
            $file = $request->file(JenisFilePengajuanProvider::NIB);
            $filename = $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . '/' . JenisFilePengajuanProvider::NIB, $filename);

            $nib_availability = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::NIB)
                ->get()
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
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }

        // ? Upload Akta
        if ($request->hasFile(JenisFilePengajuanProvider::AktaPendirian)) {
            $file = $request->file(JenisFilePengajuanProvider::AktaPendirian);
            $filename = $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::AktaPendirian, $filename);

            $akta_availability = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::AktaPendirian)
                ->get()
                ->count();

            if ($akta_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::AktaPendirian,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }

        // ? Upload SPPL
        if ($request->hasFile(JenisFilePengajuanProvider::SPPL_UKL_UPL)) {
            $file = $request->file(JenisFilePengajuanProvider::SPPL_UKL_UPL);
            $filename = $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::SPPL_UKL_UPL, $filename);

            $sppl_availability = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::SPPL_UKL_UPL)
                ->get()
                ->count();

            if ($sppl_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::SPPL_UKL_UPL,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }

        // ? Upload Proposal
        if ($request->hasFile(JenisFilePengajuanProvider::ProposalTeknis)) {
            $file = $request->file(JenisFilePengajuanProvider::ProposalTeknis);
            $filename = $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::ProposalTeknis, $filename);

            $proposal_availability = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::ProposalTeknis)
                ->get()
                ->count();

            if ($proposal_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::ProposalTeknis,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }

        // ? Upload Jaminan Pasokan
        if ($request->hasFile(JenisFilePengajuanProvider::JaminanPasokanBahanBaku)) {
            $file = $request->file(JenisFilePengajuanProvider::JaminanPasokanBahanBaku);
            $filename = $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::JaminanPasokanBahanBaku, $filename);

            $jaminan_pasokan_availability = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::JaminanPasokanBahanBaku)
                ->get()
                ->count();

            if ($jaminan_pasokan_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::JaminanPasokanBahanBaku,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }

        // ? Upload Bukti Mesin
        if ($request->hasFile(JenisFilePengajuanProvider::BuktiKepemilikanMesinUtama)) {
            $file = $request->file(JenisFilePengajuanProvider::BuktiKepemilikanMesinUtama);
            $filename = $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::BuktiKepemilikanMesinUtama, $filename);

            $bukti_mesin_availability = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::BuktiKepemilikanMesinUtama)
                ->get()
                ->count();

            if ($bukti_mesin_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::BuktiKepemilikanMesinUtama,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }

        // ? Upload Bukti Prasarana
        if ($request->hasFile(JenisFilePengajuanProvider::BuktiKepemilikanPrasaranaPabrik)) {
            $file = $request->file(JenisFilePengajuanProvider::BuktiKepemilikanPrasaranaPabrik);
            $filename = $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::BuktiKepemilikanPrasaranaPabrik, $filename);

            $bukti_prasarana_availability = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::BuktiKepemilikanPrasaranaPabrik)
                ->get()
                ->count();

            if ($bukti_prasarana_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::BuktiKepemilikanPrasaranaPabrik,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }

        // ? Upload Dokumen TKP
        if ($request->hasFile(JenisFilePengajuanProvider::DokumenTenagaKerjaProfesional)) {
            $file = $request->file(JenisFilePengajuanProvider::DokumenTenagaKerjaProfesional);
            $filename = $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::DokumenTenagaKerjaProfesional, $filename);

            $dokumen_tkp_availability = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::DokumenTenagaKerjaProfesional)
                ->get()
                ->count();

            if ($dokumen_tkp_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::DokumenTenagaKerjaProfesional,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('file_detail_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }

        $file = DB::table('file_detail_pengajuan')
            ->where('id_pengajuan', '=', $id)
            ->get();

        $status = DB::table('pengajuan')
            ->where('id', '=', $id)
            ->get(['status']);

        return back();
    }
    /**
     * * Send new Pengajuan by Middle Bussiness to Approver
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
        $file_pengajuan = DB::table('file_detail_pengajuan')
            ->where('id_pengajuan', '=', $id)
            ->get()
            ->count();

        if ($file_pengajuan !== JenisFilePengajuanProvider::JumlahJenisPengajuanTengah) {
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

        return back();
    }
    /**
     * * Approve pengajuan by Middle Business
     *
     * ! Copypasta from LowPengajuanController.php
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

        if ($checkApprovedFileCount < JenisFilePengajuanProvider::JumlahJenisPengajuanTengah || $checkApprovedFileCount > JenisFilePengajuanProvider::JumlahJenisPengajuanTengah) {
            return back()
                ->with('error', 'Masih ada file yang belum di-approve!');
        }

        // ! ================================

        $statusQuery = $request->query('status');

        if ($statusQuery === 'diterima') {
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

            $approval_pengajuan_availability = DB::table('approval_pengajuan')
                ->where('id_pengajuan', '=', $id)
                ->get()
                ->count();

            if ($approval_pengajuan_availability > 0) {
                DB::table('approval_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->update([
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Accepted,
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('approval_pengajuan')
                    ->insert([
                        'id_pengajuan' => $id,
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Accepted,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }
            // // TODO: Automatic send proposal to next approver based on queue
            // * Automatic send proposal to next approver based on queue
            $indexCurrentApprover = array_search(Auth::user()->role, UserRoleProvider::ApproverQueue);

            if ($indexCurrentApprover === count(UserRoleProvider::ApproverQueue)) {
                DB::table('pengajuan')
                    ->where('id', $id)
                    ->update([
                        'status' => StatusPengajuanProvider::Accepted,
                        'current_approver' => null
                    ]);

                Debugbar::log(UserRoleProvider::ApproverQueue[$indexCurrentApprover]);

                return back();
            }

            $nextApprover = UserRoleProvider::ApproverQueue[$indexCurrentApprover + 1];

            DB::table('pengajuan')
                ->where('id', $id)
                ->update([
                    'status' => StatusPengajuanProvider::Pending,
                    'current_approver' => $nextApprover
                ]);

            return back();
        } else if ($statusQuery === 'ditolak') {
            $checkAcceptedFile = DB::table('file_detail_pengajuan')
                ->join('approval_file_pengajuan', 'approval_file_pengajuan.id_file_pengajuan', 'file_detail_pengajuan.id')
                ->where('file_detail_pengajuan.id_pengajuan', '=', $id)
                ->where('approval_file_pengajuan.status', '=', StatusPengajuanProvider::Accepted)
                ->get()
                ->count();

            if ($checkAcceptedFile > 0) {
                return back()
                    ->with('error', 'Cek kembali file yang di-approve! Harus ada satu file yang ditolak!');
            }

            $approval_pengajuan_availability = DB::table('approval_pengajuan')
                ->where('id_pengajuan', '=', $id)
                ->get()
                ->count();

            if ($approval_pengajuan_availability > 0) {
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
                return back();
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
                return back();
            }
        } else {
            return abort(404);
        }
    }
}
