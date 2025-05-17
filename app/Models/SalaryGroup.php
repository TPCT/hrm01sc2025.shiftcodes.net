<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\SalaryGroup
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SalaryGroupEmployee> $groupEmployees
 * @property-read int|null $group_employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SalaryComponent> $salaryComponents
 * @property-read int|null $salary_components_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup active()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryGroup whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class SalaryGroup extends Model
{
    use HasFactory;

    protected $table = 'salary_groups';

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'created_by',
        'updated_by',

    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
        });

        static::deleting(function($salaryGroupDetail) {
            $salaryGroupDetail->groupEmployees()->delete();
        });
    }

    public function salaryComponents(): BelongsToMany
    {
        return $this->belongsToMany(SalaryComponent::class,
            'salary_group_component',
            'salary_group_id',
            'salary_component_id',
        );
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function groupEmployees(): HasMany
    {
        return $this->hasMany(SalaryGroupEmployee::class, 'salary_group_id', 'id');
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
