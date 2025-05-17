<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\SalaryComponent
 *
 * @property int $id
 * @property string $name
 * @property string $component_type
 * @property string $value_type
 * @property float|null $annual_component_value
 * @property int $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $apply_for_all
 * @property-read \App\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeePayslipDetail> $payslipDetail
 * @property-read int|null $payslip_detail_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SalaryGroup> $salaryGroups
 * @property-read int|null $salary_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaxReportAdditionalDetail> $taxReportAdditional
 * @property-read int|null $tax_report_additional_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent active()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent whereAnnualComponentValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent whereApplyForAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent whereComponentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryComponent whereValueType($value)
 * @mixin \Eloquent
 */
class SalaryComponent extends Model
{
    use HasFactory;

    const COMPONENT_TYPE = [
        'earning' => 'Earning',
        'deductions' => 'Deduction'
    ];

    const VALUE_TYPE = [
        'adjustable'=>'Adjustable',
        'basic' => 'Basic Percent',
        'ctc' => 'Percent',
        'fixed' => 'Fixed',
    ];

    const STATUS = [];

    protected $table = 'salary_components';

    protected $fillable = [
        'name',
        'component_type',
        'value_type',
        'annual_component_value',
        'status',
        'created_by',
        'updated_by',
        'apply_for_all'
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

    public function salaryGroups(): BelongsToMany
    {
        return $this->belongsToMany(SalaryGroup::class,'salary_group_component',
            'salary_component_id',
            'salary_group_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function payslipDetail():HasMany
    {
        return $this->hasMany(EmployeePayslipDetail::class, 'salary_component_id', 'id');
    }

    public function taxReportAdditional():HasMany
    {
        return $this->hasMany(TaxReportAdditionalDetail::class, 'salary_component_id', 'id');
    }
}
