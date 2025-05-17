<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WarningEmployee
 *
 * @property int $id
 * @property int $warning_id
 * @property int $employee_id
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\Warning $warning
 * @method static \Illuminate\Database\Eloquent\Builder|WarningEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WarningEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WarningEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|WarningEmployee whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarningEmployee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarningEmployee whereWarningId($value)
 * @mixin \Eloquent
 */
class WarningEmployee extends Model
{
    use HasFactory;
    protected $table = 'warning_employees';

    public $timestamps = false;

    protected $fillable = [
        'warning_id',
        'employee_id'
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
