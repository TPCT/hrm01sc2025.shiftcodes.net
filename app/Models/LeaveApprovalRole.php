<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LeaveApprovalRole
 *
 * @property int $id
 * @property int|null $leave_approval_id
 * @property int|null $role_id
 * @property-read \App\Models\LeaveApproval|null $leaveApproval
 * @property-read \App\Models\Role|null $role
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalRole whereLeaveApprovalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalRole whereRoleId($value)
 * @mixin \Eloquent
 */
class LeaveApprovalRole extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'leave_approval_roles';

    protected $fillable = [
        'leave_approval_id',
        'role_id',
    ];

    public function leaveApproval():BelongsTo
    {
        return $this->belongsTo(LeaveApproval::class, 'leave_approval_id', 'id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
