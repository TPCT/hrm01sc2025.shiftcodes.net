<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $post_name
 * @property int $is_active
 * @property int $dept_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $hasEmployee
 * @property-read int|null $has_employee_count
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereDeptId($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereIsActive($value)
 * @method static Builder|Post wherePostName($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'post_name',
        'is_active',
        'dept_id'
    ];

    const RECORDS_PER_PAGE = 10;

    const IS_ACTIVE = 1;

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('branch', function (Builder $builder) {

            $user = Auth::user();
            if (isset($user->branch_id) && (isset($user->id) && $user->id != 1)) {
                $branchId = $user->branch_id;
                $builder->whereHas('department', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId)->OrWhere('id',1);
                });
            }
        });
    }

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class, 'dept_id', 'id');
    }

    public function employees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class,'post_id','id')
          ->where([
          ['status', '=', 'verified'],
          ['is_active', '=', self::IS_ACTIVE ],
        ]);
    }

    public function hasEmployee()
    {
        return $this->hasMany(User::class,'post_id','id');
    }

}


