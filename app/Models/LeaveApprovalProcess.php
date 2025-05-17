<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LeaveApprovalProcess
 *
 * @property int $id
 * @property int $leave_approval_id
 * @property string $approver
 * @property int|null $user_id
 * @property int|null $role_id
 * @property-read \App\Models\LeaveApproval $leaveApproval
 * @property-read \App\Models\LeaveRequestMaster $leaveRequest
 * @property-read \App\Models\Role|null $role
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalProcess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalProcess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalProcess query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalProcess whereApprover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalProcess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalProcess whereLeaveApprovalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalProcess whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalProcess whereUserId($value)
 * @mixin \Eloquent
 */
class LeaveApprovalProcess extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'leave_approval_processes';

    protected $fillable = [
        'leave_approval_id',
        'approver',
        'role_id',
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

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id')->select('name', 'id', 'slug');
    }

    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequestMaster::class, 'leave_approval_id', 'leave_type_id');
    }
}
