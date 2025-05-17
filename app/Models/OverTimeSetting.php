<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\OverTimeSetting
 *
 * @property int $id
 * @property string|null $title
 * @property float $max_daily_ot_hours
 * @property float $max_weekly_ot_hours
 * @property float $max_monthly_ot_hours
 * @property float $valid_after_hour after how many hours ot is valid
 * @property string|null $overtime_pay_rate
 * @property int $is_active 0= inactive, 1= active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $pay_type  0=percent, 1=amount
 * @property float|null $pay_percent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OverTimeEmployee> $otEmployees
 * @property-read int|null $ot_employees_count
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting whereMaxDailyOtHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting whereMaxMonthlyOtHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting whereMaxWeeklyOtHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting whereOvertimePayRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting wherePayPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeSetting whereValidAfterHour($value)
 * @mixin \Eloquent
 */
class OverTimeSetting extends Model
{
    use HasFactory;

    protected $table = 'over_time_settings';

    protected $fillable = [
        'title','max_daily_ot_hours', 'max_weekly_ot_hours', 'max_monthly_ot_hours', 'valid_after_hour', 'overtime_pay_rate', 'is_active','pay_type','pay_percent'
    ];

    public function otEmployees(): HasMany
    {
        return $this->hasMany(OverTimeEmployee::class, 'over_time_setting_id', 'id');
    }
}
