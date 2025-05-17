<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bonus
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $value_type
 * @property float $value
 * @property int|null $applicable_month
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereApplicableMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereValueType($value)
 * @mixin \Eloquent
 */
class Bonus extends Model
{
    use HasFactory;
    protected $table = 'bonuses';

    protected $fillable = [
        'title', 'description', 'value_type', 'value', 'applicable_month', 'is_active',
    ];
}
