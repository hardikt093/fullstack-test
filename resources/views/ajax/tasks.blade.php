@if(!$tasks->isEmpty())
    @foreach($tasks as $key=>$value)
        <div class="card-body-main mb-3">
            <div class="card-body-text bg-white px-3">
                <div class="card-body-all d-flex justify-content-between mb-1">
                    <h2>{{$value->taskmaster->title}}</h2>
                    
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-angle-down"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @if($value->status == 0)
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="completeTask({{ $value->task_id }});">Complete</a></li>
                            @else
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="pendingTask({{ $value->task_id }});">Pending</a></li>
                            @endif
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteTask({{ $value->task_id }});">Delete</a></li>
                        </ul>
                    </div>
                    
                </div>
                <div class="card-text mb-1">{{ $value->taskmaster->description }}</div>
                <div class="span-text">
                    <span class="d-flex gap-2 align-items-center mb-1">
                        <a href=""><i class="fa-solid fa-clock"></i></a>
                        <p>{{$value->taskdatestring}}</p>
                    </span>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="card">
        <div class="card-body">
            <p class="card-text">No task available!</p>
        </div>
    </div>
@endif
