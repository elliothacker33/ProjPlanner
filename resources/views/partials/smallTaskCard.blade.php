<section class="taskCard small">
    <a href="{{route('task',['task'=>$task,'project'=>$project])}}">
    <header>                @if($task->status == 'open') <span class="status open"> <i class="fa-solid fa-folder-open"></i> Open </span>
        @elseif($task->status == 'closed') <span class="status closed"> <i class="fa-solid fa-folder-closed"></i> Closed </span>
        @else <span class="status cancelled"> <i class="fa-solid fa-ban"></i> Canceled </span>
        @endif
        #{{$task->id}}
        <span class="deadLine">
            <i class="fa-regular fa-calendar"></i>
            @if($task->deadline) {{ date('d-m-Y', strtotime($task->deadline)) }}
            @else There is no deadline
            @endif
        </span>
    </header>
    <p>{{$task->title}}</p>
    <section class="tags">
        @foreach($task->tags as $tag)
            <span class="tag">
                {{$tag->title}}
            </span>
        @endforeach
    </section>
    </a>
</section>