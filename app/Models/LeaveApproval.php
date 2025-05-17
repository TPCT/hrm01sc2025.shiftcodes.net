<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\LeaveApproval
 *
 * @property int $id
 * @property string $subject
 * @property int $leave_type_id
 * @property int $max_days_limit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeaveApprovalDepartment> $approvalDepartment
 * @property-read int|null $approval_department_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeaveApprovalProcess> $approvalProcess
 * @property-read int|null $approval_process_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeaveApprovalRole> $approvalRole
 * @property-read int|null $approval_role_count
 * @property-read \App\Models\LeaveType $leaveType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeaveApprovalNotificationRecipient> $notificationReceiver
 * @property-read int|null $notification_receiver_count
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApproval newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApproval newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApproval query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApproval whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApproval whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApproval whereLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApproval whereMaxDaysLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApproval whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApproval whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApproval whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeaveApproval extends Model
{
    use HasFactory;
    protected $table = 'leave_approvals';

    protected $fillable = ['subject', 'leave_type_id', 'max_days_limit','status'];

    const RECORDS_PER_PAGE = 10;

    public function approvalDepartment(): HasMany
    {
        return $this->hasMany(LeaveApprovalDepartment::class, 'leave_approval_id', 'id');
    }

    public function approvalRole(): HasMany
    {
        return $this->hasMany(LeaveApprovalRole::class, 'leave_approval_id', 'id');
    }
    public function notificationReceiver(): HasMany
    {
        return $this->hasMany(LeaveApprovalNotificationRecipient::class, 'leave_approval_id', 'id');
    }
    public function approvalProcess(): HasMany
    {
        return $this->hasMany(LeaveApprovalProcess::class, 'leave_approval_id', 'id');
    }
    public function leaveType():BelongsTo
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id');
    }
}

