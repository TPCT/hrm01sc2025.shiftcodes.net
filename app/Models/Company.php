<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property string $owner_name
 * @property string $email
 * @property string $address
 * @property string $phone
 * @property int $is_active
 * @property string|null $website_url
 * @property string|null $logo
 * @property string|null $weekend
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Branch> $branches
 * @property-read int|null $branches_count
 * @property-read User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $employee
 * @property-read int|null $employee_count
 * @property-read User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereWebsiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereWeekend($value)
 * @mixin \Eloquent
 */
class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'email',
        'owner_name',
        'address',
        'phone',
        'is_active',
        'website_url',
        'logo',
        'weekend',
        'created_by',
        'updated_by'
    ];

    const RECORDS_PER_PAGE = 10;

    const UPLOAD_PATH = 'uploads/company/logo/';


    public static function boot()
    {
        parent::boot();

        static::updating(static function ($model) {
            $model->updated_by = Auth::user()->id;
        });
    }

    protected function weekend(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value),
        );
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class,'company_id','id')
            ->select('id','name')
            ->where('is_active',1);
    }

    public function employee()
    {
        return $this->hasMany(User::class,'company_id','id')
            ->select('*')
            ->where('is_active',1)
            ->where('status','verified')
            ->orderBy('name');
    }

}
