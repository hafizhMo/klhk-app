<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pengajuan
 *
 * @property int $id
 * @property int $user_id
 * @property string $nama_pengajuan
 * @property string $no_surat
 * @property string $perihal
 * @property string $skala_usaha
 * @property string $status
 * @property string|null $current_approver
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PengajuanFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan whereCurrentApprover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan whereNamaPengajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan whereNoSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan wherePerihal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan whereSkalaUsaha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan whereUserId($value)
 * @mixin \Eloquent
 */
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
