<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\KomentarFilePengajuan
 *
 * @property int $id
 * @property int $id_pengajuan
 * @property int $user_id
 * @property string $komentar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|KomentarFilePengajuan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KomentarFilePengajuan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KomentarFilePengajuan query()
 * @method static \Illuminate\Database\Eloquent\Builder|KomentarFilePengajuan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KomentarFilePengajuan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KomentarFilePengajuan whereIdPengajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KomentarFilePengajuan whereKomentar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KomentarFilePengajuan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KomentarFilePengajuan whereUserId($value)
 * @mixin \Eloquent
 */
class KomentarFilePengajuan extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'komentar_file_pengajuan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'komentar'
    ];
}
