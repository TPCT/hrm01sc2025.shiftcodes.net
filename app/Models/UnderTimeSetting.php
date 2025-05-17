<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\UnderTimeSetting
 *
 * @property int $id
 * @property string|null $title
 * @property int $applied_after_minutes after how many minutes ut is applicable
 * @property string|null $ut_penalty_rate
 * @property int $is_active 0= inactive, 1= active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $penalty_type  0=percent, 1=amount
 * @property float|null $penalty_percent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UnderTimeEmployee> $utEmployees
 * @property-read int|null $ut_employees_count
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting whereAppliedAfterMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting wherePenaltyPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting wherePenaltyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeSetting whereUtPenaltyRate($value)
 * @mixin \Eloquent
 */
class UnderTimeSetting extends Model
{
    use HasFactory;

    protected $table = 'under_time_settings';

    protected $fillable = [
        'title','applied_after_minutes', 'ut_penalty_rate', 'is_active','penalty_type','penalty_percent'
    ];

    public function utEmployees(): HasMany
    {
        return $this->hasMany(UnderTimeEmployee::class, 'under_time_setting_id', 'id');
    }
}
