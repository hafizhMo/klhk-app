<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDetailPengajuan extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'file_detail_pengajuan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'jenis_file',
        'name',
        'type',
        'size'
    ];
}
