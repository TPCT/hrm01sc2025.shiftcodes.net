<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\OverTimeEmployee
 *
 * @property int $id
 * @property int $over_time_setting_id
 * @property int $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\OverTimeSetting $overTimeSetting
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeEmployee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeEmployee whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeEmployee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeEmployee whereOverTimeSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverTimeEmployee whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OverTimeEmployee extends Model
{
    use HasFactory;

    protected $table = 'over_time_employees';

    protected $fillable = [
        'over_time_setting_id', 'employee_id'
    ];


    public function overTimeSetting(): BelongsTo
    {
        return $this->belongsTo(OverTimeSetting::class, 'over_time_setting_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
