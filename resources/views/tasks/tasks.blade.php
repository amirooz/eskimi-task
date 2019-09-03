@extends('layouts.app')

@section('content')
<div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTaskModalLabel">Create New Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('tasks.store')}}">
                @csrf
                <div class="modal-body">

                    <div class="form-group">

                        <input type="hidden" name="progress" id="progress" value="0" />

                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" placeholder="Enter a name..." maxlength="255" class="form-control" autocomplete="off" required />
                    </div>

                    <div class="form-group">
                        <label for="user_id">Assigned To</label>
                        <select class="form-control" id="user_id" name="user_id">
                            @foreach ($users as $key => $user)
                            <option value="{{ $key }}"> {{ $user }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="points">Points</label>
                        <input id="points" name="points" type="text" value="" placeholder="Place an integer value 1-10" maxlength="2" class="form-control" autocomplete="off" required />
                    </div>

                    <div class="form-group">
                        <label for="is_done">Is Done</label>
                        <select class="form-control" id="is_done" name="is_done">
                            <option value="0">Pending</option>
                            <option value="1">Completed</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="populateData()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="pull-left">
                        <h3>Task List</h3>
                    </div>

                    <div class="pull-right">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createTaskModal" data-whatever="@mdo">New Task</button>
                    </div>
                </div>

                <div class="card-body">
                    @if($tasks)
                    <ul class="list-group">
                        @foreach ($tasks as $task)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="badge badge-pill">
                                    <form method="POST" action="{{ route('tasks.update', $task->id) }}" >
                                        @method('PATCH')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $task->id }}" />
                                        <input type="hidden" name="parent_id" value="{{ $task->parent_id }}" />
                                        <input type="hidden" name="user_id" value="{{ $task->user_id }}" />
                                        <input type="hidden" name="title" value="{{ $task->title }}" />
                                        <input type="hidden" name="points" value="{{ $task->points }}" />
                                        <input type="hidden" name="progress" value="{{ $task->points }}" />
                                        <input type="hidden" name="is_done" value="1" />
                                        <button type="submit" title="Mark as complete" ><i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                                    </form>
                                </span>
                                <span class="pull-left">
                                    {{ $task->title }}
                                </span>
                                <span class="badge badge-pill">
                                    Points: {{ $task->progress }} / {{ $task->points }} |
                                    <a href="{{ route('tasks.show', $task->id) }}" title="View the task"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a> |
                                    <a href="{{ route('tasks.edit', $task->id) }}" title="Edit the task"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    @else
                        <strong> No task found! </strong>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function populateData()
    {
        let points = document.getElementById("points").value;
        let progress = document.getElementById("progress");
        let is_done = document.getElementById("is_done").value;

        if(is_done == 0)
        {
            progress.value = 0;
        } else {
            progress.value = points;
        }
    }
</script>
