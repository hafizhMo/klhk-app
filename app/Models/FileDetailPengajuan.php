<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FileDetailPengajuan
 *
 * @property int $id
 * @property int $id_pengajuan
 * @property string $jenis_file
 * @property string $name
 * @property string $type
 * @property string $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FileDetailPengajuan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileDetailPengajuan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileDetailPengajuan query()
 * @method static \Illuminate\Database\Eloquent\Builder|FileDetailPengajuan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileDetailPengajuan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileDetailPengajuan whereIdPengajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileDetailPengajuan whereJenisFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileDetailPengajuan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileDetailPengajuan whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileDetailPengajuan whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileDetailPengajuan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
