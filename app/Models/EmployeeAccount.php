<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * App\Models\EmployeeAccount
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $bank_name
 * @property string|null $bank_account_no
 * @property string|null $bank_account_type
 * @property float|null $salary
 * @property string $salary_cycle
 * @property int|null $salary_group_id
 * @property int $allow_generate_payroll
 * @property string|null $account_holder
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\SalaryGroup|null $salaryGroup
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount whereAccountHolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount whereAllowGeneratePayroll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount whereBankAccountNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount whereBankAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount whereSalaryCycle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount whereSalaryGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAccount whereUserId($value)
 * @mixin \Eloquent
 */
class EmployeeAccount extends Model
{
    use HasFactory;

    const BANK_ACCOUNT_TYPE = ['saving', 'current', 'salary'];

    const SALARY_CYCLE = ['monthly','weekly'];

    public $timestamps = false;

    protected $table = 'employee_accounts';

    protected $fillable = [
        'user_id',
        'bank_name',
        'bank_account_no',
        'bank_account_type',
        'salary',
        'salary_cycle',
        'salary_group_id',
        'allow_generate_payroll',
        'account_holder',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function salaryGroup()
    {
        return $this->belongsTo(SalaryGroup::class,'salary_group_id','id');
    }

}
