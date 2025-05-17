<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\PaymentCurrency
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $symbol
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCurrency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCurrency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCurrency query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCurrency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCurrency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCurrency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentCurrency whereSymbol($value)
 * @mixin \Eloquent
 */
class PaymentCurrency extends Model
{
    use HasFactory;

    protected $table = 'payment_currencies';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'symbol',
    ];


}
