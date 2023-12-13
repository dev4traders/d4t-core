<?php

namespace D4T\Core\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class UserFollowed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $follower;

    public function __construct( $follower)
    {
        $this->follower = $follower;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
        ];
    }
}
