<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'pengajuan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'nama_pengajuan',
        'no_surat',
        'perihal',
        'skala_usaha'
    ];
}
