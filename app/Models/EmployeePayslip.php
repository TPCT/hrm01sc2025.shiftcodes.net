<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\EmployeePayslip
 *
 * @property int $id
 * @property int $employee_id
 * @property string|null $paid_on
 * @property string $status
 * @property string|null $remark
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $salary_group_id
 * @property string $salary_cycle
 * @property string $salary_from
 * @property string $salary_to
 * @property float $gross_salary
 * @property float $tds
 * @property float $advance_salary
 * @property float $tada
 * @property float $net_salary
 * @property int|null $total_days
 * @property int|null $present_days
 * @property int|null $absent_days
 * @property int|null $leave_days
 * @property int|null $payment_method_id
 * @property int $include_tada
 * @property int $include_advance_salary
 * @property int $attendance
 * @property int $absent_paid
 * @property int $approved_paid_leaves
 * @property float $absent_deduction
 * @property int $holidays
 * @property int $weekends
 * @property int $paid_leave
 * @property int $unpaid_leave
 * @property float $overtime
 * @property float $undertime
 * @property int $is_bs_enabled
 * @property float $ssf_deduction
 * @property float $ssf_contribution
 * @property float $bonus
 * @property-read \App\Models\User $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeePayslipDetail> $payslipDetail
 * @property-read int|null $payslip_detail_count
 * @property-read \App\Models\SalaryGroup|null $salaryGroup
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereAbsentDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereAbsentDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereAbsentPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereAdvanceSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereApprovedPaidLeaves($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereAttendance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereGrossSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereHolidays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereIncludeAdvanceSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereIncludeTada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereIsBsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereLeaveDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereNetSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereOvertime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip wherePaidLeave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip wherePaidOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip wherePresentDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereSalaryCycle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereSalaryFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereSalaryGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereSalaryTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereSsfContribution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereSsfDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereTada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereTds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereTotalDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereUndertime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereUnpaidLeave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeePayslip whereWeekends($value)
 * @mixin \Eloquent
 */
class EmployeePayslip extends Model
{
    use HasFactory;

    protected $table = 'employee_payslips';

    const UPLOAD_PATH = 'uploads/payslip/';

    public $timestamps = true;

    protected $fillable = [

        'employee_id',
        'paid_on',
        'status',
        'remark',
        'salary_group_id',
        'salary_cycle',
        'salary_from',
        'salary_to',
        'gross_salary',
        'tds',
        'advance_salary',
        'tada',
        'net_salary',
        'total_days',
        'present_days',
        'absent_days',
        'leave_days',
        'created_by',
        'updated_by',
        'payment_method_id',
        'include_tada',
        'include_advance_salary',
        'attendance',
        'absent_paid',
        'approved_paid_leaves',
        'absent_deduction',
        'holidays',
        'weekends',
        'paid_leave',
        'unpaid_leave',
        'overtime',
        'undertime',
        'created_at',
        'updated_at',
        'is_bs_enabled',
        'ssf_deduction',
        'ssf_contribution',
        'bonus'

    ];

    public function payslipDetail():HasMany
    {
        return $this->hasMany(EmployeePayslipDetail::class, 'employee_payslip_id', 'id');
    }

    public function salaryGroup()
    {
        return $this->belongsTo(SalaryGroup::class,'salary_group_id','id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class,'employee_id','id');
    }
}
