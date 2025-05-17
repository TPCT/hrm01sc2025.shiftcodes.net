<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\TaxReportComponentDetail
 *
 * @property int $id
 * @property int $tax_report_id
 * @property int $salary_component_id
 * @property string $type
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SalaryComponent $salaryComponent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaxReport> $taxReport
 * @property-read int|null $tax_report_count
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportComponentDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportComponentDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportComponentDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportComponentDetail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportComponentDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportComponentDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportComponentDetail whereSalaryComponentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportComponentDetail whereTaxReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportComponentDetail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportComponentDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaxReportComponentDetail extends Model
{
    use HasFactory;

    protected $table = 'tax_report_component_details';

    protected $fillable = [
        'tax_report_id', 'salary_component_id', 'type', 'month', 'amount',
    ];

    public function salaryComponent():BelongsTo
    {
        return $this->belongsTo(SalaryComponent::class,'salary_component_id','id');
    }

    public function taxReport(): HasMany
    {
        return $this->hasMany(TaxReport::class,'tax_report_id','id');
    }
}
