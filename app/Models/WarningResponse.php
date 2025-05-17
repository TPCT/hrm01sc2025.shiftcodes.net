<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WarningResponse
 *
 * @property int $id
 * @property int $warning_id
 * @property int $employee_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\Warning $warning
 * @method static \Illuminate\Database\Eloquent\Builder|WarningResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WarningResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WarningResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder|WarningResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarningResponse whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarningResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarningResponse whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarningResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarningResponse whereWarningId($value)
 * @mixin \Eloquent
 */
class WarningResponse extends Model
{
    use HasFactory;

    protected $table = 'warning_responses';

    protected $fillable = [
        'warning_id',
        'employee_id',
        'message'
    ];

    public function warning()
    {
        return $this->belongsTo(Warning::class, 'warning_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
