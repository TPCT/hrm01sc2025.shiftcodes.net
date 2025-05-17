<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SalaryGroupEmployee
 *
 * @property int $id
 * @property int $salary_group_id
 * @property int $employee_id
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\SalaryGroup $salaryGroup
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroupEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroupEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroupEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroupEmployee whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroupEmployee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroupEmployee whereSalaryGroupId($value)
 * @mixin \Eloquent
 */
class SalaryGroupEmployee extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'salary_group_employees';

    protected $fillable = [
        'salary_group_id',
        'employee_id'
    ];

    public function salaryGroup(): BelongsTo
    {
        return $this->belongsTo(SalaryGroup::class, 'salary_group_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
