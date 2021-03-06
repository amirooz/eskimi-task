@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        @if($tasks)
            @foreach ($tasks as $k => $data)
                <div class="col-md-4 mb-30">
                    <div class="card">
                        <div class="card-header">{{ $users[$k] }}
                            <span class="badge badge-pill">
                            </span>
                        </div>
                        <ul class="task-group">
                            @foreach ($data as $task)
                            <li class="task-list">
                                {{  $task['title'] }}
                                <span class="badge badge-pill">
                                    {{ $task['progress'] }} / {{ $task['points'] }}
                                </span>
                                @if(isset($task['subtask']))
                                    <ul class="task-group">
                                        @foreach ($task['subtask'] as $task)
                                        <li class="task-list">
                                            {{  $task['title'] }}
                                            <span class="badge badge-pill">
                                                {{ $task['progress'] }} / {{ $task['points'] }}
                                            </span>
                                            @if(isset($task['subtask']))
                                                <ul class="task-group">
                                                    @foreach ($task['subtask'] as $task)
                                                    <li class="task-list">
                                                        {{  $task['title'] }}
                                                        <span class="badge badge-pill">
                                                            {{ $task['progress'] }} / {{ $task['points'] }}
                                                        </span>
                                                        @if(isset($task['subtask']))
                                                            <ul class="task-group">
                                                                @foreach ($task['subtask'] as $task)
                                                                <li class="task-list">
                                                                    {{  $task['title'] }}
                                                                    <span class="badge badge-pill">
                                                                        {{ $task['progress'] }} / {{ $task['points'] }}
                                                                    </span>
                                                                    @if(isset($task['subtask']))
                                                                        <ul class="task-group">
                                                                            @foreach ($task['subtask'] as $task)
                                                                            <li class="task-list">
                                                                                {{  $task['title'] }}
                                                                                <span class="badge badge-pill">
                                                                                    {{ $task['progress'] }} / {{ $task['points'] }}
                                                                                </span>
                                                                                @if(isset($task['subtask']))

                                                                                @endif
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach

        @else
            <h2>Nobody likes an empty dashboard... <a class="btn btn-primary" href="{{ route('tasks.index')}}"> Create Task</a></h2>
        @endif
    </div>
</div>
@endsection
