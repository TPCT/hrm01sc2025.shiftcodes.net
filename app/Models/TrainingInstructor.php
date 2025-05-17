<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TrainingInstructor
 *
 * @property int $id
 * @property string $trainer_type
 * @property int $training_id
 * @property int $trainer_id
 * @property-read \App\Models\Trainer $trainer
 * @property-read \App\Models\Training $training
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingInstructor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingInstructor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingInstructor query()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingInstructor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingInstructor whereTrainerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingInstructor whereTrainerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingInstructor whereTrainingId($value)
 * @mixin \Eloquent
 */
class TrainingInstructor extends Model
{
    use HasFactory;
    protected $table = 'training_instructors';

    public $timestamps = false;

    protected $fillable = [
        'trainer_type',
        'training_id',
        'trainer_id',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id', 'id');
    }
}
