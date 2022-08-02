<?php

namespace App\Http\Controllers\Pengajuan\Middle;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\UserRoleProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Storage;
use App\Providers\StatusPengajuanProvider;
use App\Providers\JenisFilePengajuanProvider;


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
        // ================================
        // ? Check User Role
        // ? If user is normal user, get pengajuan by the user id
        // ? Else show all pengajuan related
        // ================================
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

        $approval_pengajuan = DB::table('approval_pengajuan')
            ->where('id_pengajuan', '=', $id)
            ->get();

        $file_approval_binary = null;
        $already_approve = null;
        if ($approval_pengajuan->count() > 0) {
            $file_approval = DB::table('file_approval_pengajuan')
                ->where('id_approval_pengajuan', $approval_pengajuan[0]->id_pengajuan)
                ->get();

            if ($file_approval->count() > 0) {
                $file_path = 'approval_pengajuan/' . $id . '/' . $file_approval[0]->name;
                if (Storage::exists($file_path)) {
                    $file_approval_binary = Storage::get($file_path);
                }

                $already_approve = DB::table('approval_pengajuan')
                    ->join('users', 'users.id', 'approval_pengajuan.user_id')
                    ->where('users.role', '=', Auth::user()->role)
                    ->get()
                    ->count();
            }
        }

        return view('uploads.middle')
            // ? Data User yang ter-login
            ->with('user', Auth::user())
            // ? File dokumen yang terupload untuk ID pengajuan tersebut
            ->with('detail_pengajuan', $file)
            // ? Status pengajuan (Ditolak/Diterima/Pending/Not Submitted)
            ->with('status', $status[0]->status)
            // ? Untuk munculkan button untuk tolak atau setujui pengajuan (Untuk role selain user)
            ->with('approved', $already_approve ?? $already_approve > 0 ? true : false)
            // ? File Approval yang diupload oleh approver (Surat Penolakan atau Surat Persetujuan)
            ->with('file_approval', base64_encode($file_approval_binary))
            // ? Id dari Pengajuan
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
                    ->update([
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'updated_at' => Carbon::now()
                    ]);
                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::NIB . '/' . $nib[0]->name);
            }
        }

        // ? Upload Akta
        if ($request->hasFile(JenisFilePengajuanProvider::AktaPendirian)) {
            $file = $request->file(JenisFilePengajuanProvider::AktaPendirian);
            $filename = JenisFilePengajuanProvider::AktaPendirian . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::AktaPendirian, $filename);

            $akta = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::AktaPendirian)
                ->get();

            $akta_availability = $akta
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
                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::AktaPendirian . '/' . $akta[0]->name);
            }
        }

        // ? Upload SPPL
        if ($request->hasFile(JenisFilePengajuanProvider::SPPL_UKL_UPL)) {
            $file = $request->file(JenisFilePengajuanProvider::SPPL_UKL_UPL);
            $filename = JenisFilePengajuanProvider::SPPL_UKL_UPL . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::SPPL_UKL_UPL, $filename);

            $sppl = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::SPPL_UKL_UPL)
                ->get();

            $sppl_availability = $sppl
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

                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::SPPL_UKL_UPL . '/' . $sppl[0]->name);
            }
        }

        // ? Upload Proposal
        if ($request->hasFile(JenisFilePengajuanProvider::ProposalTeknis)) {
            $file = $request->file(JenisFilePengajuanProvider::ProposalTeknis);
            $filename = JenisFilePengajuanProvider::ProposalTeknis . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::ProposalTeknis, $filename);

            $proposal = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::ProposalTeknis)
                ->get();

            $proposal_availability = $proposal
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
                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::ProposalTeknis . '/' . $proposal[0]->name);
            }
        }

        // ? Upload Jaminan Pasokan
        if ($request->hasFile(JenisFilePengajuanProvider::JaminanPasokanBahanBaku)) {
            $file = $request->file(JenisFilePengajuanProvider::JaminanPasokanBahanBaku);
            $filename = JenisFilePengajuanProvider::JaminanPasokanBahanBaku . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::JaminanPasokanBahanBaku, $filename);

            $jaminan_pasokan = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::JaminanPasokanBahanBaku)
                ->get();

            $jaminan_pasokan_availability = $jaminan_pasokan
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
                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::JaminanPasokanBahanBaku . '/' . $jaminan_pasokan[0]->name);
            }
        }

        // ? Upload Bukti Mesin
        if ($request->hasFile(JenisFilePengajuanProvider::BuktiKepemilikanMesinUtama)) {
            $file = $request->file(JenisFilePengajuanProvider::BuktiKepemilikanMesinUtama);
            $filename = JenisFilePengajuanProvider::BuktiKepemilikanMesinUtama . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::BuktiKepemilikanMesinUtama, $filename);

            $bukti_mesin = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::BuktiKepemilikanMesinUtama)
                ->get();

            $bukti_mesin_availability = $bukti_mesin
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
                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::BuktiKepemilikanMesinUtama . '/' . $bukti_mesin[0]->name);
            }
        }

        // ? Upload Bukti Prasarana
        if ($request->hasFile(JenisFilePengajuanProvider::BuktiKepemilikanPrasaranaPabrik)) {
            $file = $request->file(JenisFilePengajuanProvider::BuktiKepemilikanPrasaranaPabrik);
            $filename = JenisFilePengajuanProvider::BuktiKepemilikanPrasaranaPabrik . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::BuktiKepemilikanPrasaranaPabrik, $filename);

            $bukti_prasarana = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::BuktiKepemilikanPrasaranaPabrik)
                ->get();

            $bukti_prasarana_availability = $bukti_prasarana
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
                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::BuktiKepemilikanPrasaranaPabrik . '/' . $bukti_prasarana[0]->name);
            }
        }

        // ? Upload Dokumen TKP
        if ($request->hasFile(JenisFilePengajuanProvider::DokumenTenagaKerjaProfesional)) {
            $file = $request->file(JenisFilePengajuanProvider::DokumenTenagaKerjaProfesional);
            $filename = JenisFilePengajuanProvider::DokumenTenagaKerjaProfesional . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::DokumenTenagaKerjaProfesional, $filename);

            $dokumen_tkp = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::DokumenTenagaKerjaProfesional)
                ->get();

            $dokumen_tkp_availability = $dokumen_tkp
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
                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::DokumenTenagaKerjaProfesional . '/' . $dokumen_tkp[0]->name);
            }
        }

        // ? Upload Berita Acara
        if ($request->hasFile(JenisFilePengajuanProvider::BeritaAcara)) {
            $file = $request->file(JenisFilePengajuanProvider::BeritaAcara);
            $filename = JenisFilePengajuanProvider::BeritaAcara . '_' . $base_filename . "." . $file->extension();

            $file->storeAs($storagePathPengajuan . JenisFilePengajuanProvider::BeritaAcara, $filename);

            $berita_acara = DB::table('file_detail_pengajuan')
                ->where('id_pengajuan', '=', $pengajuan[0]->id)
                ->where('jenis_file', '=', JenisFilePengajuanProvider::BeritaAcara)
                ->get();

            $berita_acara_availability = $berita_acara
                ->count();

            if ($berita_acara_availability === 0) {
                DB::table('file_detail_pengajuan')
                    ->insert([
                        'id_pengajuan' => $pengajuan[0]->id,
                        'jenis_file' => JenisFilePengajuanProvider::BeritaAcara,
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
                Storage::delete($storagePathPengajuan . JenisFilePengajuanProvider::BeritaAcara . '/' . $berita_acara[0]->name);
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
        $file_pengajuan = $file
            ->count();

        if ($file_pengajuan < JenisFilePengajuanProvider::JumlahJenisPengajuanTengah) {
            return back()
                ->with('error', 'Ada file pengajuan yang belum diupload, silahkan dicek kembali');
        }
        // ====================

        $get_current_approver = DB::table('pengajuan')
            ->where('id', '=', $id)
            ->get(['current_approver'])[0]
            ->current_approver;

        // ? Jika belum ada approver atau pengajuan baru diajukan ke sistem
        if ($get_current_approver === null) {
            DB::table('pengajuan')
                ->where('id', '=', $id)
                ->update([
                    'status' => StatusPengajuanProvider::Pending,
                    'current_approver' => UserRoleProvider::ApproverQueue[0]
                ]);
        } else {
            // ? Ambil role approver saat ini
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

        // ? Aksi penerimaan pengajuan tengah
        if ($statusQuery === 'diterima') {
            // ? Aksi tambahan untuk Kepala Dinas
            if (Auth::user()->role === 'kadin') {
                // ? Upload Surat Persetujan dari Kadin
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

                // ! Check count of rejected file
                if ($checkRejectedFile > 0) {
                    return back()
                        ->with('error', 'Cek kembali file yang di-approve! Masih ada file yang ditolak!');
                }
            }

            // ? ==========================================

            $approval_pengajuan = DB::table('approval_pengajuan')
                ->where('id_pengajuan', '=', $id)
                ->get();

            $approval_pengajuan_availability = $approval_pengajuan
                ->count();

            // ? Jika sudah pernah approve, update approval
            if ($approval_pengajuan_availability > 0) {
                DB::table('approval_pengajuan')
                    ->where('id_pengajuan', '=', $id)
                    ->update([
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Accepted,
                        'komentar' => $request->input('komentar'),
                        'updated_at' => Carbon::now()
                    ]);
                // ? Aksi tambahan untuk Kepala Dinas
                if (Auth::user()->role === 'kadin') {
                    $file_approval_pengajuan = DB::table('file_approval_pengajuan')
                        ->where('id_approval_pengajuan', '=', $approval_pengajuan[0]->id)
                        ->get();
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
            // ? Jika belum pernah approve, buat approval baru
            else {
                DB::table('approval_pengajuan')
                    ->insert([
                        'id_pengajuan' => $id,
                        'user_id' => Auth::id(),
                        'status' => StatusPengajuanProvider::Accepted,
                        'komentar' => $request->input('komentar'),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                // ? Aksi tambahan untuk Kepala Dinas
                if (Auth::user()->role === 'kadin') {
                    $approval_pengajuan = DB::table('approval_pengajuan')
                        ->where('id_pengajuan', '=', $id)
                        ->get();
                    DB::table('file_approval_pengajuan')
                        ->insert([
                            'id_approval_pengajuan' => $approval_pengajuan[0]->id,
                            'name' => $filename,
                            'type' => $file->extension(),
                            'size' => $file->getSize(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                }
            }
            // * Automatic send proposal to next approver based on queue
            $indexCurrentApprover = array_search(Auth::user()->role, UserRoleProvider::ApproverQueue);

            if ($indexCurrentApprover === count(UserRoleProvider::ApproverQueue)) {
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

            return back();
        }
        // ? Aksi penolakan pengajuan tengah
        else if ($statusQuery === 'ditolak') {
            // ? Upload Surat Penolakan dari Approver
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

            $checkAcceptedFile = DB::table('file_detail_pengajuan')
                ->join('approval_file_pengajuan', 'approval_file_pengajuan.id_file_pengajuan', 'file_detail_pengajuan.id')
                ->where('file_detail_pengajuan.id_pengajuan', '=', $id)
                ->where('approval_file_pengajuan.status', '=', StatusPengajuanProvider::Accepted)
                ->get()
                ->count();

            // // ! Check count of accepted file
            // ? File yang terima tidak perlu diupload ulang
            // if ($checkAcceptedFile > 0) {
            //     return back()
            //         ->with('error', 'Cek kembali file yang di-approve! Tidak boleh ada satu file yang diterima!');
            // }

            $approval_pengajuan_availability = DB::table('approval_pengajuan')
                ->where('id_pengajuan', '=', $id)
                ->get()
                ->count();

            // ! Check Uploaded Surat Penolakan
            if (!$request->hasFile('surat_penolakan')) {
                return back()
                    ->with('error', 'Butuh surat penolakan!');
            }

            $file->storeAs($storagePathApprovalPengajuan, $filename);

            $approval_pengajuan = DB::table('approval_pengajuan')
                ->where('id_pengajuan', '=', $id)
                ->get();

            $approval_pengajuan_availability = $approval_pengajuan->count();

            $file_approval_pengajuan = DB::table('file_approval_pengajuan')
                ->where('id_approval_pengajuan', '=', $approval_pengajuan[0]->id)
                ->get();

            // ? Jika sudah pernah approve, update approval
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
            // ? Jika belum pernah approve, buat approval baru
            else {
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
                DB::table('file_approval_pengajuan')
                    ->insert([
                        'id_approval_pengajuan' => $approval_pengajuan[0]->id,
                        'name' => $filename,
                        'type' => $file->extension(),
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }
            return back();
        } else {
            return abort(404);
        }
    }
}
