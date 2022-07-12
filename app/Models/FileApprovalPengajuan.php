<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FileApprovalPengajuan
 *
 * @property int $id
 * @property int $id_approval_pengajuan
 * @property string $name
 * @property string $type
 * @property string $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FileApprovalPengajuan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileApprovalPengajuan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileApprovalPengajuan query()
 * @method static \Illuminate\Database\Eloquent\Builder|FileApprovalPengajuan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileApprovalPengajuan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileApprovalPengajuan whereIdApprovalPengajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileApprovalPengajuan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileApprovalPengajuan whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileApprovalPengajuan whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileApprovalPengajuan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FileApprovalPengajuan extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'file_approval_pengajuan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'type',
        'size'
    ];
}
