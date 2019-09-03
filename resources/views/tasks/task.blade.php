@extends('layouts.app')

@section('content')
<div class="modal fade" id="createSubTaskModal" tabindex="-1" role="dialog" aria-labelledby="createSubTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSubTaskModalLabel">Create Sub Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('tasks.store')}}">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <input type="hidden" name="grand_grand_id" id="grand_grand_id" value="{{ $task->grand_parent_id }}"/>
                        <input type="hidden" name="grand_parent_id" id="grand_parent_id" value="{{ $task->grand_id }}"/>
                        <input type="hidden" name="grand_id" id="grand_id" value="{{ $task->parent_id }}"/>
                        <input type="hidden" name="parent_id" id="parent_id" value="{{ $task->id }}"/>
                        <input type="hidden" name="progress" id="progress" value="0"/>
                        @if($task->is_done == 1)
                            <input type="hidden" name="is_done" id="is_done" value="1"/>
                        @endif
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" value="" maxlength="255" class="form-control" autocomplete="off" autofocus required />
                    </div>

                    <div class="form-group">
                        <label for="user_id">Assigned To</label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="{{ $task->user_id }}">{{ $users[$task->user_id] }}</option>
                            @foreach ($users as $key => $user)
                            <option value="{{ $key }}"> {{ $user }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="points">Points</label>
                        <input id="points" name="points" type="text" value="0" maxlength="2" class="form-control" autocomplete="off" required />
                    </div>

                    @if($task->is_done == 0)
                    <div class="form-group">
                        {!! Form::Label('is_done', 'Is Done:') !!}
                        {!! Form::select('is_done', $yesNo, $task->is_done, ['class' => 'form-control', 'onChange' => 'populateData()']) !!}
                    </div>
                    @endif

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
            <div class="card card-new-task">
                <div class="card-header">
                    <div class="pull-left">
                        <h3>{{ $task->title }}</h3>
                    </div>
                    <div class="pull-right">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createSubTaskModal" data-whatever="@mdo">Create Sub Task</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td><strong>Parent Id : </strong></td>
                            <td>{{ $task->parent_id }}</td>
                            <td><strong>Assigned To : </strong></td>
                            <td>{{ $users[$task->user_id] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Points : </strong></td>
                            <td>{{ $task->points }}</td>
                            <td><strong>Progress : </strong></td>
                            <td>{{ $task->progress }} / {{ $task->points }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status : </strong></td>
                            <td>{{ $task->is_done == 0 ? 'Pending' : 'Completed' }}</td>
                            <td><strong>Created AT : </strong></td>
                            <td>{{ date('Y-m-d', strtotime($task->created_at)) }}</td>
                        </tr>
                    </table>
                    <div class="pull-right">
                        <a href="{{ route('tasks.index') }}" class="btn btn-primary" >Back</a>
                    </div>
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
        }
        else
        {
            progress.value = points;
        }
    }
</script>
