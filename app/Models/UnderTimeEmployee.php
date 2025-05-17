<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UnderTimeEmployee
 *
 * @property int $id
 * @property int $under_time_setting_id
 * @property int $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\UnderTimeSetting $underTimeSetting
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeEmployee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeEmployee whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeEmployee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeEmployee whereUnderTimeSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnderTimeEmployee whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UnderTimeEmployee extends Model
{
    use HasFactory;

    protected $table = 'under_time_employees';

    protected $fillable = [
        'under_time_setting_id', 'employee_id'
    ];


    public function underTimeSetting(): BelongsTo
    {
        return $this->belongsTo(UnderTimeSetting::class, 'under_time_setting_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
