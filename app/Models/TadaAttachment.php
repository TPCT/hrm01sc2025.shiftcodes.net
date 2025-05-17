<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TadaAttachment
 *
 * @property int $id
 * @property int $tada_id
 * @property string $attachment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tada $tada
 * @method static \Illuminate\Database\Eloquent\Builder|TadaAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TadaAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TadaAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|TadaAttachment whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TadaAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TadaAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TadaAttachment whereTadaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TadaAttachment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TadaAttachment extends Model
{
    use HasFactory;

    protected $table = 'tada_attachments';

    protected $fillable = [
        'tada_id',
        'attachment'
    ];

    const ATTACHMENT_UPLOAD_PATH = 'uploads/tada/attachment/';

    public function tada()
    {
        return $this->belongsTo(Tada::class, 'tada_id', 'id');
    }

}
