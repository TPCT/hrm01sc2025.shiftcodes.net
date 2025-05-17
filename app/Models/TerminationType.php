<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\TerminationType
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $branch_id
 * @property-read \App\Models\Branch|null $branch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Termination> $terminations
 * @property-read int|null $terminations_count
 * @method static Builder|TerminationType newModelQuery()
 * @method static Builder|TerminationType newQuery()
 * @method static Builder|TerminationType query()
 * @method static Builder|TerminationType whereBranchId($value)
 * @method static Builder|TerminationType whereCreatedAt($value)
 * @method static Builder|TerminationType whereId($value)
 * @method static Builder|TerminationType whereStatus($value)
 * @method static Builder|TerminationType whereTitle($value)
 * @method static Builder|TerminationType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TerminationType extends Model
{
    use HasFactory;

    protected $table = 'termination_types';

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

    public function terminations(): HasMany
    {
        return $this->hasMany(Termination::class, 'termination_type_id', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
