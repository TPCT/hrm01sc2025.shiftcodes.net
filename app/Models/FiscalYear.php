<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FiscalYear
 *
 * @property int $id
 * @property string|null $year
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $is_running
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalYear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalYear query()
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalYear whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalYear whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalYear whereIsRunning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalYear whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalYear whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiscalYear whereYear($value)
 * @mixin \Eloquent
 */
class FiscalYear extends Model
{
    use HasFactory;

    protected $table = 'fiscal_years';

    protected $fillable = [
        'year', 'start_date', 'end_date', 'is_running'
    ];
}
