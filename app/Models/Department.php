<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $dept_name
 * @property string $slug
 * @property string $address
 * @property string|null $phone
 * @property int $is_active
 * @property int|null $dept_head_id
 * @property int $company_id
 * @property int $branch_id
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $departmentHead
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Department newModelQuery()
 * @method static Builder|Department newQuery()
 * @method static Builder|Department query()
 * @method static Builder|Department whereAddress($value)
 * @method static Builder|Department whereBranchId($value)
 * @method static Builder|Department whereCompanyId($value)
 * @method static Builder|Department whereCreatedAt($value)
 * @method static Builder|Department whereCreatedBy($value)
 * @method static Builder|Department whereDeptHeadId($value)
 * @method static Builder|Department whereDeptName($value)
 * @method static Builder|Department whereId($value)
 * @method static Builder|Department whereIsActive($value)
 * @method static Builder|Department wherePhone($value)
 * @method static Builder|Department whereSlug($value)
 * @method static Builder|Department whereUpdatedAt($value)
 * @method static Builder|Department whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'dept_name',
        'slug',
        'address',
        'phone',
        'is_active',
        'dept_head_id',
        'company_id',
        'branch_id',
        'created_by',
        'updated_by'
    ];

    const RECORDS_PER_PAGE = 10;

    const IS_ACTIVE = 1;

    const UPLOAD_PATH = 'uploads/department/';


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
            $model->updated_by = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
        });

        if (Auth::check() && Auth::user()->id != 1) {
            static::addGlobalScope('branch', function (Builder $builder) {
                $user = Auth::user();
                if (isset($user->branch_id)) {
                    $branchId = $user->branch_id;
                    $builder->whereHas('branch', function ($query) use ($branchId) {
                        $query->where('id', $branchId);
                    });
                }
            });
        }
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function departmentHead()
    {
        return $this->belongsTo(User::class, 'dept_head_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'dept_id','id')->select('id','post_name')->where('is_active',1);
    }

    public function employees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class,'department_id','id')
            ->where([
                ['status', '=', 'verified'],
                ['is_active', '=', self::IS_ACTIVE ],
            ]);
    }

}

