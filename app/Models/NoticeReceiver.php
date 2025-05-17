<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NoticeReceiver
 *
 * @property int $id
 * @property \App\Models\Notice $notice_id
 * @property int $notice_receiver_id
 * @property-read \App\Models\User $employee
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeReceiver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeReceiver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeReceiver query()
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeReceiver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeReceiver whereNoticeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeReceiver whereNoticeReceiverId($value)
 * @mixin \Eloquent
 */
class NoticeReceiver extends Model
{
    use HasFactory;

    protected $table = 'notice_receivers';

    public $timestamps = false;

    protected $fillable = [
        'notice_id',
        'notice_receiver_id'
    ];

    public function notice_id()
    {
        return $this->belongsTo(Notice::class, 'notice_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'notice_receiver_id', 'id');
    }
}
