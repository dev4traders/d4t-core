<?php

namespace D4T\Core\Models;

use D4T\Core\CoreServiceProvider;
use D4T\Core\Traits\HasCountedEnum;
use Illuminate\Database\Eloquent\Model;
use D4T\Core\Enums\HelpdeskTicketStatus;
use D4T\Core\Traits\HasDateTimeFormatter;
use D4T\Core\Enums\HelpdeskTicketPriority;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     title="HelpdeskTicket",
 *     description="HelpdeskTicket model",
 *     @OA\Xml(
 *         name="HelpdeskTicket"
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
class HelpdeskTicket extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;
    use HasCountedEnum;

    protected $table = 'helpdesk_tickets';

    protected $casts = [
        'status' => HelpdeskTicketStatus::class,
        'priority' => HelpdeskTicketPriority::class
    ];

    protected $fillable = [
        'author_id', 'description', 'subject', 'status', 'priority',
        'regarding_type', 'regarding_id', 'last_commentator_id', 'read_at', 'domain_id'
    ];

    public function author()
    {
        $model = CoreServiceProvider::getUserModel();
        return $this->belongsTo($model);
    }

    public function last_commentator()
    {
        $model = CoreServiceProvider::getUserModel();
        return $this->belongsTo($model, 'last_commentator_id');
    }

    public function comments()
    {
        return $this->hasMany(HelpdeskTicketComment::class, 'ticket_id');
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }

    public function scopeOpen($query) {
        $query->where('status', HelpdeskTicketStatus::OPEN);
    }

    public function scopeClosed($query) {
        $query->where('status', HelpdeskTicketStatus::CLOSED);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->status = HelpdeskTicketStatus::OPEN;
            $query->read_at = $query->freshTimestamp();
        });
    }

    /**
     * Mark the notification as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * Mark the notification as unread.
     *
     * @return void
     */
    public function markAsUnread()
    {
        if (! is_null($this->read_at)) {
            $this->forceFill(['read_at' => null])->save();
        }
    }


}
