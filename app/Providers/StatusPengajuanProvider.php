<?php

namespace App\Providers;

abstract class StatusPengajuanProvider
{
    /**
     * ? Belum dikirim ke approver
     */
    const NotSubmitted = 'not submitted';
    /**
     * ? Sedang direview oleh approver
     */
    const Pending = 'pending';
    /**
     * ? Ditolak oleh approver
     */
    const Rejected = 'ditolak';
    /**
     * ? Diterima oleh approver
     */
    const Accepted = 'diterima';
}
