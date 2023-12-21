<section class="projectCard">
    <ul>
        <li>
            <header>
                <h3><a href="{{route('project',['project'=>$project])}}">{{$project->title}}</a></h3>
                @if(!$project->is_archived) <span class="status open"> <i class="fa-solid fa-box-open"></i> Open </span>
                @else <span class="status archive"> <i class="fa-solid fa-box-archive"></i> Archive </span>
                @endif
            </header>
        </li>
        <li class="deadLine"><i class="fa-regular fa-calendar"></i>
            @if($project->deadline) {{ date('d-m-Y', strtotime($project->deadline)) }}
            @else There is no deadline
            @endif
        </li>
    </ul>
    <h6>#{{$project->id}} Created on {{ date('d-m-Y', strtotime($project->creation)) }} and coordinate by {{$project->coordinator->name}}</h6>
</section>