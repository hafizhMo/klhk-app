<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
 */
	class ApprovalFilePengajuan extends \Eloquent {}
}

namespace App\Models{
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
 */
	class FileDetailPengajuan extends \Eloquent {}
}

namespace App\Models{
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
 */
	class KomentarFilePengajuan extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Pengajuan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

