<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserNotification
 *
 * @property int $id
 * @property int $notification_id
 * @property int $user_id
 * @property int $is_seen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $notification
 * @property-read \App\Models\User $userDetail
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereIsSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereUserId($value)
 * @mixin \Eloquent
 */
class UserNotification extends Model
{
    use HasFactory;

    protected $table = 'user_notifications';

    protected $fillable = [
        'notification_id',
        'user_id',
        'is_seen',
    ];

    public function userDetail(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function notification(): BelongsTo
    {
        return $this->belongsTo(User::class, 'notification_id', 'id');
    }

}

