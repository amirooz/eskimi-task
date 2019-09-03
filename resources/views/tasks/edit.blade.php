@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card card-new-task">
                <div class="card-header"> Edit Task</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tasks.update', $task->id) }}" id="edit_task" >
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="grand_grand_id" id="grand_grand_id" value="{{ $task->grand_grand_id }}" />
                            <input type="hidden" name="grand_parent_id" id="grand_parent_id" value="{{ $task->grand_parent_id }}" />
                            <input type="hidden" name="grand_id" id="grand_id" value="{{ $task->grand_id }}" />
                            <input type="hidden" name="parent_id" id="parent_id" value="{{ $task->parent_id }}" />
                            <input type="hidden" name="progress" id="progress" value="{{ $task->progress }}" />
                            <label for="title">Title</label>
                            <input id="title" name="title" type="text" value="{{ $task->title }}" maxlength="255" class="form-control" autocomplete="off" required />
                        </div>
                        <div class="form-group">
                            <label for="user_id">Assigned To</label>
                            <select class="form-control" id="user_id" name="user_id" >
                                <option value="{{ $task->user_id }}">{{ $users[$task->user_id] }}</option>
                                @foreach ($users as $key => $user)
                                <option value="{{ $key }}"> {{ $user }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="points">Points</label>
                            <input id="points" name="points" type="text" value="{{ $task->points }}" maxlength="2" class="form-control" autocomplete="off" required />
                        </div>
                        <div class="form-group">
                            {!! Form::Label('is_done', 'Is Done:') !!}
                            {!! Form::select('is_done', $yesNo, $task->is_done, ['class' => 'form-control' ]) !!}
                        </div>

                        <button type="submit" onclick="populateData()" class="btn btn-success">Update</button>
                        <a class="btn btn-secondary" href="{{ route('tasks.index')}}">Return</a>
                    </form>
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
