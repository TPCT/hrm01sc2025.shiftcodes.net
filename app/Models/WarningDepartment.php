<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WarningDepartment
 *
 * @property int $id
 * @property int $warning_id
 * @property int $department_id
 * @property-read \App\Models\Department $department
 * @property-read \App\Models\Warning $warning
 * @method static \Illuminate\Database\Eloquent\Builder|WarningDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WarningDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WarningDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder|WarningDepartment whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarningDepartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarningDepartment whereWarningId($value)
 * @mixin \Eloquent
 */
class WarningDepartment extends Model
{
    use HasFactory;

    protected $table = 'warning_departments';

    public $timestamps = false;

    protected $fillable = [
        'warning_id',
        'department_id'
    ];

    public function warning()
    {
        return $this->belongsTo(Warning::class, 'warning_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
