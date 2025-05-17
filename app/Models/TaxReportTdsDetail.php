<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TaxReportTdsDetail
 *
 * @property int $id
 * @property int $tax_report_id
 * @property int $month
 * @property float $amount
 * @property int $is_paid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TaxReport $taxReport
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportTdsDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportTdsDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportTdsDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportTdsDetail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportTdsDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportTdsDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportTdsDetail whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportTdsDetail whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportTdsDetail whereTaxReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportTdsDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaxReportTdsDetail extends Model
{
    use HasFactory;

    protected $table = 'tax_report_tds_details';

    protected $fillable = [
        'tax_report_id', 'month', 'amount', 'is_paid',
    ];

    public function taxReport():BelongsTo
    {
        return $this->belongsTo(TaxReport::class,'tax_report_id','id');
    }

}
