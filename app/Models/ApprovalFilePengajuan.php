<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApprovalFilePengajuan
 *
 * @property int $id
 * @property int $user_id
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalFilePengajuan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalFilePengajuan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalFilePengajuan query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalFilePengajuan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalFilePengajuan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalFilePengajuan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalFilePengajuan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalFilePengajuan whereUserId($value)
 * @mixin \Eloquent
 * @property int $id_file_pengajuan
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalFilePengajuan whereIdFilePengajuan($value)
 */
class ApprovalFilePengajuan extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'approval_file_pengajuan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}
