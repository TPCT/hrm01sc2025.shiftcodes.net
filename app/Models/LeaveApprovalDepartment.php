<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LeaveApprovalDepartment
 *
 * @property int $id
 * @property int|null $leave_approval_id
 * @property int|null $department_id
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\LeaveApproval|null $leaveApproval
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalDepartment whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalDepartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApprovalDepartment whereLeaveApprovalId($value)
 * @mixin \Eloquent
 */
class LeaveApprovalDepartment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'leave_approval_departments';

    protected $fillable = [
        'leave_approval_id',
        'department_id',
    ];

    public function leaveApproval():BelongsTo
    {
        return $this->belongsTo(LeaveApproval::class, 'leave_approval_id', 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

}
