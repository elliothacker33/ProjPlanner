<?php

namespace App\Events;

use App\Models\Project;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $project;
    public $message;

    public function __construct(Project $project, $message)
    {
        $this->project = $project;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('tutorial02');
    }
    public function broadcastAs() {
        return 'notification-postlike';
    }

}
