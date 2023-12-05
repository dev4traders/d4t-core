<?php

namespace D4T\Core\Models;

use D4T\Core\CoreServiceProvider;
use D4T\Core\Models\HelpdeskTicket;
use Illuminate\Database\Eloquent\Model;
use D4T\Core\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     title="HelpdeskTicketComment",
 *     description="HelpdeskTicketComment model",
 *     @OA\Xml(
 *         name="HelpdeskTicketComment"
 *     ),
 * @OA\Property(
 *     property="id",
 *     title="ID",
 *     description="ID",
 *     format="int64",
 *     example=1
 * )
 * )
*/
class HelpdeskTicketComment extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'helpdesk_ticket_comments';

    protected $fillable = [
        'author_id', 'ticket_id', 'body'
    ];

    public function author() : BelongsTo
    {
        $model = CoreServiceProvider::getUserModel();
        return $this->belongsTo($model);
    }

    public function ticket() : BelongsTo
    {
        return $this->belongsTo(HelpdeskTicket::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function(HelpdeskTicketComment $comment) {
            $comment->ticket()->rawUpdate(
                [
                    'updated_at' => $comment->freshTimestampString(),
                    'last_commentator_id' => $comment->author_id,
                ]
                );
        });

    }

}
