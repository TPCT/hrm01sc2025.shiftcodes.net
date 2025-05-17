<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmployeeSalary
 *
 * @property int $id
 * @property int $employee_id
 * @property float $annual_salary
 * @property string $basic_salary_type in:'percent','fixed'
 * @property float|null $basic_salary_value
 * @property float $monthly_basic_salary
 * @property float $annual_basic_salary
 * @property float $monthly_fixed_allowance
 * @property float $annual_fixed_allowance
 * @property int|null $salary_group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float|null $hour_rate
 * @property float $weekly_basic_salary
 * @property float $weekly_fixed_allowance
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereAnnualBasicSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereAnnualFixedAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereAnnualSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereBasicSalaryType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereBasicSalaryValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereHourRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereMonthlyBasicSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereMonthlyFixedAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereSalaryGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereWeeklyBasicSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereWeeklyFixedAllowance($value)
 * @mixin \Eloquent
 */
class EmployeeSalary extends Model
{
    use HasFactory;

    protected $table = 'employee_salaries';

    protected $fillable = ['employee_id', 'annual_salary', 'basic_salary_type', 'basic_salary_value', 'monthly_basic_salary', 'annual_basic_salary',
        'monthly_fixed_allowance', 'annual_fixed_allowance', 'salary_group_id','hour_rate','weekly_basic_salary','weekly_fixed_allowance'];


}
