<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\TrainingType
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $branch_id
 * @property-read \App\Models\Branch|null $branch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Training> $trainings
 * @property-read int|null $trainings_count
 * @method static Builder|TrainingType newModelQuery()
 * @method static Builder|TrainingType newQuery()
 * @method static Builder|TrainingType query()
 * @method static Builder|TrainingType whereBranchId($value)
 * @method static Builder|TrainingType whereCreatedAt($value)
 * @method static Builder|TrainingType whereId($value)
 * @method static Builder|TrainingType whereStatus($value)
 * @method static Builder|TrainingType whereTitle($value)
 * @method static Builder|TrainingType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TrainingType extends Model
{
    use HasFactory;

    protected $table = 'training_types';

    protected $fillable = [
        'title','status','branch_id'
    ];
    public static function boot()
    {
        parent::boot();

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereNotNull('branch_id')
                    ->whereHas('branch', function ($query) use ($branchId) {
                        $query->where('id', $branchId);
                    });

            });
        }
    }


    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class, 'training_type_id', 'id');
    }
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
