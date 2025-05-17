<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Promotion
 *
 * @property int $id
 * @property int $branch_id
 * @property int $department_id
 * @property int $employee_id
 * @property int $post_id
 * @property string $promotion_date
 * @property string|null $description
 * @property string $status
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $remark
 * @property int|null $old_post_id
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Department $department
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\Post|null $oldPost
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Promotion newModelQuery()
 * @method static Builder|Promotion newQuery()
 * @method static Builder|Promotion query()
 * @method static Builder|Promotion whereBranchId($value)
 * @method static Builder|Promotion whereCreatedAt($value)
 * @method static Builder|Promotion whereCreatedBy($value)
 * @method static Builder|Promotion whereDepartmentId($value)
 * @method static Builder|Promotion whereDescription($value)
 * @method static Builder|Promotion whereEmployeeId($value)
 * @method static Builder|Promotion whereId($value)
 * @method static Builder|Promotion whereOldPostId($value)
 * @method static Builder|Promotion wherePostId($value)
 * @method static Builder|Promotion wherePromotionDate($value)
 * @method static Builder|Promotion whereRemark($value)
 * @method static Builder|Promotion whereStatus($value)
 * @method static Builder|Promotion whereUpdatedAt($value)
 * @method static Builder|Promotion whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Promotion extends Model
{
    use HasFactory;
    protected $table = 'promotions';
    protected $fillable = [
        'branch_id', 'department_id', 'employee_id', 'post_id', 'promotion_date', 'description', 'status', 'created_by', 'updated_by','remark','old_post_id'
    ];


    const RECORDS_PER_PAGE = 20;

    public static function boot()
    {
        parent::boot();

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereHas('branch', function ($query) use ($branchId) {
                    $query->where('id', $branchId);
                });

            });
        }
    }


    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id','id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }
    public function oldPost()
    {
        return $this->belongsTo(Post::class,'old_post_id','id');
    }

}
