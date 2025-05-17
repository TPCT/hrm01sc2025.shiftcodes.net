<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TaxReportDetail
 *
 * @property int $id
 * @property int $tax_report_id
 * @property int $month
 * @property float $salary
 * @property float $basic_salary
 * @property float $fixed_allowance
 * @property float $ssf_contribution
 * @property float $ssf_deduction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TaxReport $taxReport
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail whereBasicSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail whereFixedAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail whereSsfContribution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail whereSsfDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail whereTaxReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaxReportDetail extends Model
{
    use HasFactory;
    protected $table = 'tax_report_details';

    protected $fillable = [
        'tax_report_id', 'month', 'salary', 'basic_salary','fixed_allowance','ssf_contribution','ssf_deduction',
    ];

    public function taxReport():BelongsTo
    {
        return $this->belongsTo(TaxReport::class,'tax_report_id','id');
    }


}
