<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * App\Models\CompanyContentManagement
 *
 * @property int $id
 * @property string $title
 * @property string $title_slug
 * @property string $content_type
 * @property string $description
 * @property int $is_active
 * @property int $company_id
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement whereContentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement whereTitleSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyContentManagement whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class CompanyContentManagement extends Model
{
    use HasFactory;

    protected $table = 'company_content_management';

    protected $fillable = [
        'title',
        'title_slug',
        'content_type',
        'description',
        'is_active',
        'company_id',
        'created_by',
        'updated_by'
    ];

    const RECORDS_PER_PAGE = 10;

    const CONTENT_TYPE = ['company-rules','terms-and-conditions','about-us','app-policy','company-policy'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
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
}
