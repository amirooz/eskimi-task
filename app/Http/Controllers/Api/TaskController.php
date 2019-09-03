<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\TaskRepository;

class TaskController extends Controller
{
    private $task;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $task)
    {
        $this->task = $task;
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task = $this->task->all();
        if($task)
        {
            return response()->json(array('success' => true, $task, 'message' => count($task).' items are found'), 200);
        }
        else
        {
            return response()->json(array('success' => false, 'message' => 'No data found!'), 400);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = $this->task->create($request->except(['id']));
        $where['parent_id'] = [$request->parent_id];
        $points = DB::table('tasks')->where($where)->sum('points');
        $progress = DB::table('tasks')->where($where)->sum('progress');
        if($points == $progress)
        {
            DB::table('tasks')
                ->where('id', $request->parent_id)
                ->update([
                    'points'    => $points,
                    'progress'  => $progress,
                    'is_done'   => 1
                ]);
        } else {
            DB::table('tasks')
                ->where('id', $request->parent_id)
                ->update([
                    'points'    => $points,
                    'progress'  => $progress,
                    'is_done'   => 0
                ]);
        }
        if($task)
        {
            return response()->json(array('success' => true, $task, 'message' => 'Task created successfully'), 200);

        }
        else
        {
            return response()->json(array('success' => false, 'message' => 'Store failed!'), 400);
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
        if($task)
        {
            return response()->json(array('success' => true, $task, 'message' => 'Found id: '.$id ), 200);
        }
        else
        {
            return response()->json(array('success' => false, 'message' => 'Data not found'), 400);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = $this->task->update($id, $request->except(['id']));
        $points = DB::table('tasks')->where('parent_id', $request->parent_id)->sum('points');
        $progress = DB::table('tasks')->where('parent_id', $request->parent_id)->sum('progress');
        if($points == $progress)
        {
            DB::table('tasks')
                ->where('id', $request->parent_id)
                ->update([
                    'points'    => $points,
                    'progress'  => $progress,
                    'is_done'   => 1
                ]);
        } else {
            DB::table('tasks')
                ->where('id', $request->parent_id)
                ->update([
                    'points'    => $points,
                    'progress'  => $progress,
                    'is_done'   => 0
                ]);
        }


        if($task)
        {
            return response()->json(array('success' => true, $task, 'message' => 'Successfully updated'), 200);
        }
        else
        {
            return response()->json(array('success' => false, 'message' => 'Update failed!'), 400);

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
        if($id)
        {
            return response()->json(array('success' => true, $this->tasks->delete($id), 'message' => 'Delete Successfully'), 200);
        }
        else
        {
            return response()->json(array('success' => false, 'message' => 'Delete failed!'), 400);
        }
    }
}
