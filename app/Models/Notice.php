<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Notice
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $notice_publish_date
 * @property int $company_id
 * @property int $is_active
 * @property int $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NoticeReceiver> $noticeReceiversDetail
 * @property-read int|null $notice_receivers_detail_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Notice newModelQuery()
 * @method static Builder|Notice newQuery()
 * @method static Builder|Notice query()
 * @method static Builder|Notice whereCompanyId($value)
 * @method static Builder|Notice whereCreatedAt($value)
 * @method static Builder|Notice whereCreatedBy($value)
 * @method static Builder|Notice whereDescription($value)
 * @method static Builder|Notice whereId($value)
 * @method static Builder|Notice whereIsActive($value)
 * @method static Builder|Notice whereNoticePublishDate($value)
 * @method static Builder|Notice whereTitle($value)
 * @method static Builder|Notice whereUpdatedAt($value)
 * @method static Builder|Notice whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Notice extends Model
{
    use HasFactory;

    protected $table = 'notices';

    protected $fillable = [
        'title',
        'description',
        'notice_publish_date',
        'company_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    const RECORDS_PER_PAGE = 20;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
            $model->notice_publish_date = Carbon::now()->format('Y-m-d H:i:s');
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
            $model->notice_publish_date = Carbon::now()->format('Y-m-d H:i:s');
        });

        static::deleting(function($noticeDetail) {
            $noticeDetail->noticeReceiversDetail()->delete();
        });

        static::addGlobalScope('branch', function (Builder $builder) {
            $user = Auth::user();
            if (isset($user->branch_id) && (isset($user->id) && $user->id != 1)) {
                $branchId = $user->branch_id;
                $builder->whereHas('createdBy', function ($query) use ($branchId) {
                    $query->where(function($q) use ($branchId) {
                        $q->whereNull('branch_id')
                            ->where('id', 1)
                            ->orWhere('branch_id', $branchId);
                    });
                });
            }
        });

    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function noticeReceiversDetail()
    {
        return $this->hasMany(NoticeReceiver::class,'notice_id','id')->whereHas('employee');
    }
}
