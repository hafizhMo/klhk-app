<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApprovalPengajuan
 *
 * @property int $id
 * @property int $user_id
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalPengajuan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalPengajuan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalPengajuan query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalPengajuan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalPengajuan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalPengajuan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalPengajuan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalPengajuan whereUserId($value)
 * @mixin \Eloquent
 * @property int $id_pengajuan
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovalPengajuan whereIdPengajuan($value)
 */
class ApprovalPengajuan extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'approval_pengajuan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'status',
        'komentar'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}
