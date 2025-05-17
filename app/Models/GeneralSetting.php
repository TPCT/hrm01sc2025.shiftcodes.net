<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\GeneralSetting
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting whereValue($value)
 * @mixin \Eloquent
 */
class GeneralSetting extends Model
{
    use HasFactory;

    protected $table = 'general_settings';

    protected $fillable = [
        'name',
        'type',
        'key',
        'value',
    ];

    const GENERAL_SETTING_KEY = ['firebase_key'];

}

