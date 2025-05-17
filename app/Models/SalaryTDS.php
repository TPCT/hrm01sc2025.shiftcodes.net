<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\SalaryTDS
 *
 * @property int $id
 * @property float $annual_salary_from
 * @property float $annual_salary_to
 * @property string $tds_in_percent
 * @property string $marital_status
 * @property int $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS active()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS whereAnnualSalaryFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS whereAnnualSalaryTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS whereTdsInPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryTDS whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class SalaryTDS extends Model
{
    use HasFactory;

    protected $table = 'salary_t_d_s';

    public $timestamps = false;

    protected $fillable = [
        'annual_salary_from',
        'annual_salary_to',
        'tds_in_percent',
        'marital_status',
        'status',
        'created_by',
        'updated_by'
    ];

    const MARITAL_STATUS = [
        'single',
        'married'
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
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status',true);
    }
}
