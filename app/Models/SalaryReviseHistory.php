<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\SalaryReviseHistory
 *
 * @property int $id
 * @property int $employee_id
 * @property string $salary_revised_on
 * @property float $increment_amount
 * @property float $base_salary
 * @property float $revised_salary
 * @property-read string|null $remark
 * @property int $created_by
 * @property int|null $updated_by
 * @property float $increment_percent
 * @property int|null $fiscal_year_id
 * @property string|null $date_from
 * @property string|null $date_to
 * @property float|null $base_monthly_salary
 * @property float|null $base_weekly_salary
 * @property float|null $base_monthly_allowance
 * @property float|null $base_weekly_allowance
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereBaseMonthlyAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereBaseMonthlySalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereBaseSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereBaseWeeklyAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereBaseWeeklySalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereFiscalYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereIncrementAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereIncrementPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereRevisedSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereSalaryRevisedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryReviseHistory whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class SalaryReviseHistory extends Model
{
    use HasFactory;

    protected $table = 'salary_revise_histories';

    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'salary_revised_on',
        'increment_amount',
        'revised_salary',
        'base_salary',
        'remark',
        'created_by',
        'updated_by',
        'increment_percent',
        'fiscal_year_id',
        'date_from',
        'date_to',
        'base_monthly_salary',
        'base_weekly_salary',
        'base_monthly_allowance',
        'base_weekly_allowance',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
        });
    }

    public function remark(): Attribute
    {
        return new Attribute(
            get: fn($value) => strip_tags($value)
        );
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
