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

class ProjectNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $project;
    public $description;
    public $date;
    public $seen;

    public function __construct(Project $project, $message)
    {
        $this->project = $project;
        $this->message = $message;
        $this->date = Now();
        $this->seen= False;

    }

    public function broadcastOn()
    {
        return new Channel('project.'. $this->project->id);
    }


}
