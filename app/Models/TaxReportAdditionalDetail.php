<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TaxReportAdditionalDetail
 *
 * @property int $id
 * @property int $tax_report_id
 * @property int $salary_component_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SalaryComponent $salaryComponent
 * @property-read \App\Models\TaxReport $taxReport
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportAdditionalDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportAdditionalDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportAdditionalDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportAdditionalDetail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportAdditionalDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportAdditionalDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportAdditionalDetail whereSalaryComponentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportAdditionalDetail whereTaxReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportAdditionalDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaxReportAdditionalDetail extends Model
{
    use HasFactory;

    protected $table = 'tax_report_additional_details';

    protected $fillable = [
        'tax_report_id', 'salary_component_id', 'amount',
    ];

    public function taxReport():BelongsTo
    {
        return $this->belongsTo(TaxReport::class,'tax_report_id','id');
    }
    public function salaryComponent():BelongsTo
    {
        return $this->belongsTo(SalaryComponent::class,'salary_component_id','id');
    }

}
