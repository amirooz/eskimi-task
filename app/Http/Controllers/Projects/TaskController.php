<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\TaskRepository;
use App\Http\Controllers\Projects\GuzzleHttpController;
use App\Http\Requests\TaskRequest;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskController extends Controller
{
    private $task;
    private $users;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $task, GuzzleHttpController $guzzle)
    {
        $this->task = $task;
        $this->users = $guzzle->index();
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $tasks = $this->task->get();
        $yesNo = array_prepend(config('taskarray.yesNo'),'-Select-','');
        return view('tasks.tasks',['users' => $this->users, 'tasks' => $tasks, 'yesNo' => $yesNo ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $task = $this->task->create($request->except(['id']));
        $where_pid['parent_id'] = [$request->parent_id];
        $where_id['id'] = [$request->parent_id];
        $points = $this->task->where($where_pid)->sum('points');
        $progress = $this->task->where($where_pid)->sum('progress');
        if($points == $progress)
        {
            $this->task
                ->where($where_id)
                ->update([
                    'points'    => $points,
                    'progress'  => $progress,
                    'is_done'   => 1
                ]);
        } else {
            $this->task
                ->where($where_id)
                ->update([
                    'points'    => $points,
                    'progress'  => $progress,
                    'is_done'   => 0
                ]);
        }
        if ($task) {
            return redirect()->route('tasks.index')->with('status','Task created Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->task->find($id);
        $yesNo = array_prepend(config('taskarray.yesNo'),'-Select-','');
        return view('tasks.task',['users' => $this->users, 'task' => $task, 'yesNo' => $yesNo ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = $this->task->find($id);
        $yesNo = array_prepend(config('taskarray.yesNo'),'-Select-','');
        return view('tasks.edit',['users' => $this->users, 'task' => $task, 'yesNo' => $yesNo ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $task = $this->task->update($id, $request->except(['id']));
        $where_pid['parent_id'] = [$request->parent_id];
        $where_id['id'] = [$request->parent_id];
        $points = $this->task->where($where_pid)->sum('points');
        $progress = $this->task->where($where_pid)->sum('progress');
        if($points == $progress)
        {
            $this->task
                ->where($where_id)
                ->update([
                    'points'    => $points,
                    'progress'  => $progress,
                    'is_done'   => 1
                ]);
        } else {
            $this->task
                ->where($where_id)
                ->update([
                    'points'    => $points,
                    'progress'  => $progress,
                    'is_done'   => 0
                ]);
        }

        if ($task) {
            return redirect()->route('tasks.index')->with('status','Task updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $task = $this->tasks->delete($id);
        if ($task) {
            return redirect()->route('tasks.index')->with('status','Task updated Successfully');
        }
    }
}
