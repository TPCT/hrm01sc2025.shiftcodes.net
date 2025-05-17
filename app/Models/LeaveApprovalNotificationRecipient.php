<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LeaveApprovalNotificationRecipient
 *
 * @property int $id
 * @property int|null $leave_approval_id
 * @property int|null $user_id
 * @property-read \App\Models\LeaveApproval|null $leaveApproval
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalNotificationRecipient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalNotificationRecipient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalNotificationRecipient query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalNotificationRecipient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalNotificationRecipient whereLeaveApprovalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalNotificationRecipient whereUserId($value)
 * @mixin \Eloquent
 */
class LeaveApprovalNotificationRecipient extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'leave_approval_notification_recipients';

    protected $fillable = [
        'leave_approval_id',
        'user_id',
    ];

    public function leaveApproval():BelongsTo
    {
        return $this->belongsTo(LeaveApproval::class, 'leave_approval_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
