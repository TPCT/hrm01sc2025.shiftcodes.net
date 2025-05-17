<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmployeeLeaveType
 *
 * @property int $id
 * @property int $employee_id
 * @property int $leave_type_id
 * @property int $days
 * @property int $is_active
 * @property int $early_exit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeLeaveType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeLeaveType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeLeaveType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeLeaveType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeLeaveType whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeLeaveType whereEarlyExit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeLeaveType whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeLeaveType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeLeaveType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeLeaveType whereLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeLeaveType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmployeeLeaveType extends Model
{
    use HasFactory;

    protected $table = 'employee_leave_types';

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'days',
        'is_active',
        'early_exit',
    ];
}
