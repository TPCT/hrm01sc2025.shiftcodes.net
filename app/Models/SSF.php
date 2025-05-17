<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SSF
 *
 * @property int $id
 * @property float|null $office_contribution
 * @property float|null $employee_contribution
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SSF newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SSF newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SSF query()
 * @method static \Illuminate\Database\Eloquent\Builder|SSF whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSF whereEmployeeContribution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSF whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSF whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSF whereOfficeContribution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSF whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SSF extends Model
{
    use HasFactory;

    protected $table = 'ssf';

    protected $fillable = [
        'office_contribution', 'employee_contribution','is_active'
    ];
}
