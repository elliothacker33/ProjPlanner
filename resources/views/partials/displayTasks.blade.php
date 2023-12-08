@foreach($tasks as $task)
    <div class="tasks">

        <section class="task"> <a href="{{route('task',['project'=>$project->id,'task'=>$task->id])}}"> {!! $task->title !!} </a> </section>
        <section class="status"> {!! $task->status !!} </section>

    </div>

@endforeach
