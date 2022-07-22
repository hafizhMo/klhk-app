<?php

namespace App\Providers;

abstract class JenisFilePengajuanProvider
{
    /**
     * ? Jumlah Jenis File Pengajuan untuk Bisnis Bawah
     */
    const JumlahJenisPengajuanBawah = 5;
    /**
     * ? Jumlah Jenis File Pengajuan untuk Bisnis Tengah
     */
    const JumlahJenisPengajuanTengah = 8;
    /**
     * ? Surat Permohonan ditujukan kepada kepala Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Timur Bermaterai Rp. 10.000,-
     */
    const SuratPermohonan = 'surat_permohonan';
    /**
     * ? Nomor Induk Berusaha (NIB)
     */
    const NIB = 'nib';
    /**
     * ? Surat Pernyataan Pengelolaan Lingkungan (SPPL)
     */
    const SPPL = 'sppl';
    /**
     * ? Surat Pernyataan yang berisi jenis Pengolahan Hasil Hutan, Mesin Utama Produksi, dan kapasitas produksi
     */
    const SuratPernyataan = 'surat_pernyataan';
    /**
     * ? Pernyataan Mandiri dari OSS
     */
    const PenyataanMandiriOSS = 'pernyataan_oss';
    /**
     * ? Akta Pendirian
     */
    const AktaPendirian = 'akta';
    /**
     * ? Dokumen Lingkungan Hidup berupa Surat Pernyataan Pengelolaan Lingkungan (SPPL) Upaya Pengelolaan Lingkungan dan Upaya Pemantauan Lingkungan (UKL-UPL)
     */
    const SPPL_UKL_UPL = 'sppl_ukl_upl';
    /**
     * ? Proposal Teknis
     */
    const ProposalTeknis = 'proposal';
    /**
     * ? Jaminan pasokan bahan baku (dokumen kerjasama pasokan bahan baku atau pernyataan kesanggupan pemenuhan bahan baku dari pemasok)
     */
    const JaminanPasokanBahanBaku = 'jaminan_pasokan';
    /**
     * ? Bukti kepemilikan mesin utama produksi pengolahan hasil hutan atau pernyataan kesanggupan pemenuhan rencana pengadaan mesin utama produksi
     */
    const BuktiKepemilikanMesinUtama = 'bukti_mesin';
    /**
     * ? Bukti/Dokumen kepemilikan atau penguasaan atas prasarana bangunan pabrik, tempat atau lahan penampungan bahan baku dan gudang kayu olahan
     */
    const BuktiKepemilikanPrasaranaPabrik = 'bukti_prasarana';
    /**
     * ? Dokumen tenaga kerja professional bersertifikat atau pernyataan komitmen pemenuhan tenaga teknis profesional bersertifikat
     */
    const DokumenTenagaKerjaProfesional = 'dokumen_tkp';
    /**
     * ? Berita acara pengajuan usaha menengah
     */
    const BeritaAcara = 'berita_acara';
}
