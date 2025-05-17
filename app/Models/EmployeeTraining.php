<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmployeeTraining
 *
 * @property int $id
 * @property int $training_id
 * @property int $employee_id
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\Training $training
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereTrainingId($value)
 * @mixin \Eloquent
 */
class EmployeeTraining extends Model
{
    use HasFactory;
    protected $table = 'employee_trainings';

    public $timestamps = false;

    protected $fillable = [
        'training_id',
        'employee_id'
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
