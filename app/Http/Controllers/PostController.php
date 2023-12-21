<?php

namespace App\Http\Controllers;

use App\Events\PostNotificationEvent;
use App\Events\ProjectNotification;
use App\Models\Project;
use http\Env\Response;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function send(Request $request)
    {
        //return response()->json(1);
        event(new ProjectNotification(Project::find(1), 'New notification message'));
        return response()->json(2);
    }

}
