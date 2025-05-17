<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TrainingDepartment
 *
 * @property int $id
 * @property int $training_id
 * @property int $department_id
 * @property-read \App\Models\Department $department
 * @property-read \App\Models\Training $training
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDepartment whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDepartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDepartment whereTrainingId($value)
 * @mixin \Eloquent
 */
class TrainingDepartment extends Model
{
    use HasFactory;
    protected $table = 'training_departments';

    public $timestamps = false;

    protected $fillable = [
        'training_id',
        'department_id'
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
