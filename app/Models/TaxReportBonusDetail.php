<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TaxReportBonusDetail
 *
 * @property int $id
 * @property int $tax_report_id
 * @property int $bonus_id
 * @property int $month
 * @property float $amount
 * @property float $tax
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bonus $bonus
 * @property-read \App\Models\TaxReport $taxReport
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportBonusDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportBonusDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportBonusDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportBonusDetail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportBonusDetail whereBonusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportBonusDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportBonusDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportBonusDetail whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportBonusDetail whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportBonusDetail whereTaxReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxReportBonusDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaxReportBonusDetail extends Model
{
    use HasFactory;

    protected $table = 'tax_report_bonus_details';

    protected $fillable = [
        'tax_report_id', 'bonus_id', 'month', 'amount','tax'
    ];

    public function taxReport():BelongsTo
    {
        return $this->belongsTo(TaxReport::class,'tax_report_id','id');
    }

    public function bonus():BelongsTo
    {
        return $this->belongsTo(Bonus::class,'bonus_id','id');
    }

}
