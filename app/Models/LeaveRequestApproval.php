<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LeaveRequestApproval
 *
 * @property int $id
 * @property int $leave_request_id
 * @property int $status
 * @property int $approved_by
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $approvedBy
 * @property-read \App\Models\LeaveRequestMaster $leaveRequest
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequestApproval newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequestApproval newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequestApproval query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequestApproval whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequestApproval whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequestApproval whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequestApproval whereLeaveRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequestApproval whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequestApproval whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequestApproval whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeaveRequestApproval extends Model
{
    use HasFactory;

    protected $table = 'leave_request_approvals';

    protected $fillable = [
        'leave_request_id',
        'status',
        'approved_by',
        'reason'
    ];



    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function leaveRequest(): BelongsTo
    {
        return $this->belongsTo(LeaveRequestMaster::class, 'leave_request_id', 'id');
    }
}
