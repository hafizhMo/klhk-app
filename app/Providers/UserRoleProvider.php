<?php

namespace App\Providers;

abstract class UserRoleProvider
{
    /**
     * ? User biasa (Approvee)
     */
    const User = 'user';
    /**
     * ? Bagian Penelaah Berkas (Approver 1)
     */
    const PenelaahBerkas = 'penelaah_berkas';
    /**
     * ? PBPHH (Approver 2)
     */
    const PBPHH = 'pbphh';
    /**
     * ? Kepala Bidang PHPL (Approver 3)
     */
    const KabidPHPL = 'kabid_phpl';
    /**
     * ? Kepala Dinas Kehutanan (Approver 4)
     */
    const Kadin = 'kadin';
    /**
     * ? Approver Queue
     */
    const ApproverQueue = [
        0 => UserRoleProvider::PenelaahBerkas,
        1 => UserRoleProvider::PBPHH,
        2 => UserRoleProvider::KabidPHPL,
        3 => UserRoleProvider::Kadin
    ];
}
