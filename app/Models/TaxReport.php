<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\TaxReport
 *
 * @property int $id
 * @property int $employee_id
 * @property int $fiscal_year_id
 * @property float $total_basic_salary
 * @property float $total_allowance
 * @property float $total_ssf_contribution
 * @property float $total_ssf_deduction
 * @property float $female_discount
 * @property float $other_discount
 * @property float $total_payable_tds
 * @property float $total_paid_tds
 * @property float $total_due_tds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed|null $months
 * @property float $medical_claim
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaxReportAdditionalDetail> $additionalDetail
 * @property-read int|null $additional_detail_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaxReportBonusDetail> $bonusDetail
 * @property-read int|null $bonus_detail_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaxReportComponentDetail> $componentDetail
 * @property-read int|null $component_detail_count
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\FiscalYear $fiscalYear
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaxReportDetail> $reportDetail
 * @property-read int|null $report_detail_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaxReportTdsDetail> $tdsDetail
 * @property-read int|null $tds_detail_count
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereFemaleDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereFiscalYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereMedicalClaim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereOtherDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereTotalAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereTotalBasicSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereTotalDueTds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereTotalPaidTds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereTotalPayableTds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereTotalSsfContribution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereTotalSsfDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaxReport extends Model
{
    use HasFactory;

    protected $table = 'tax_reports';

    protected $fillable = [
        'employee_id', 'fiscal_year_id', 'total_basic_salary', 'total_allowance', 'total_ssf_contribution', 'total_ssf_deduction', 'female_discount',
        'other_discount', 'total_payable_tds', 'total_paid_tds', 'total_due_tds','months'
    ];

    public function fiscalYear():BelongsTo
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id', 'id');
    }

    public function employee():BelongsTo
    {
        return $this->belongsTo(User::class,'employee_id','id');
    }

    public function additionalDetail(): HasMany
    {
        return $this->hasMany(TaxReportAdditionalDetail::class,'tax_report_id','id');
    }
    public function bonusDetail(): HasMany
    {
        return $this->hasMany(TaxReportBonusDetail::class,'tax_report_id','id');
    }
    public function tdsDetail(): HasMany
    {
        return $this->hasMany(TaxReportTdsDetail::class,'tax_report_id','id');
    }
    public function componentDetail(): HasMany
    {
        return $this->hasMany(TaxReportComponentDetail::class,'tax_report_id','id');
    }

    public function reportDetail(): HasMany
    {
        return $this->hasMany(TaxReportDetail::class,'tax_report_id','id');
    }
}
