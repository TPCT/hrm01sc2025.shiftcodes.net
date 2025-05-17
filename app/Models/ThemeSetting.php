<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ThemeSetting
 *
 * @property int $id
 * @property string $primary_color
 * @property string $hover_color
 * @property string $dark_primary_color
 * @property string $dark_hover_color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeSetting whereDarkHoverColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeSetting whereDarkPrimaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeSetting whereHoverColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeSetting wherePrimaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ThemeSetting extends Model
{
    use HasFactory;

    protected $table = 'theme_settings';

    protected $fillable = [
        'primary_color',
        'hover_color',
        'dark_primary_color',
        'dark_hover_color',
    ];
}
