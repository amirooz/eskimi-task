<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Projects\GuzzleHttpController;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\TaskRepository;

class DashboardController extends Controller
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
        $result = $this->task->get();
        $tasks = [];
        foreach ($result as $key => $task) {

            if($task['parent_id'])
            {
                if($task['grand_id'])
                {
                    if($task['grand_parent_id'])
                    {
                        if($task['grand_grand_id'])
                        {
                            $ggid = $task['grand_grand_id'];
                            $gpid = $task['grand_parent_id'];
                            $gid = $task['grand_id'];
                            $pid = $task['parent_id'];
                            $id = $task['id'];
                            $uid = $task['user_id'];
                            $tasks[$uid][$ggid]['subtask'][$gpid]['subtask'][$gid]['subtask'][$pid]['subtask'][] = [
                                'id' => $task['id'],
                                'grand_grand_id' => $task['grand_grand_id'],
                                'grand_parent_id' => $task['grand_parent_id'],
                                'grand_id' => $task['grand_id'],
                                'parent_id' => $task['parent_id'],
                                'user_id' => $task['user_id'],
                                'title' => $task['title'],
                                'points' => $task['points'],
                                'progress' => $task['progress'],
                                'is_done' => $task['is_done'],
                                'created_at' => $task['created_at'],
                                'updated_at' => $task['updated_at'],
                                'created_by' => $task['created_by'],
                                'updated_by' => $task['updated_by']
                            ];
                        }
                        else
                        {
                            $gpid = $task['grand_parent_id'];
                            $gid = $task['grand_id'];
                            $pid = $task['parent_id'];
                            $id = $task['id'];
                            $uid = $task['user_id'];
                            $tasks[$uid][$gpid]['subtask'][$gid]['subtask'][$pid]['subtask'][$id] = [
                                'id' => $task['id'],
                                'grand_grand_id' => $task['grand_grand_id'],
                                'grand_parent_id' => $task['grand_parent_id'],
                                'grand_id' => $task['grand_id'],
                                'parent_id' => $task['parent_id'],
                                'user_id' => $task['user_id'],
                                'title' => $task['title'],
                                'points' => $task['points'],
                                'progress' => $task['progress'],
                                'is_done' => $task['is_done'],
                                'created_at' => $task['created_at'],
                                'updated_at' => $task['updated_at'],
                                'created_by' => $task['created_by'],
                                'updated_by' => $task['updated_by']
                            ];
                        }
                    }
                    else
                    {
                        $gid = $task['grand_id'];
                        $pid = $task['parent_id'];
                        $id = $task['id'];
                        $uid = $task['user_id'];
                        $tasks[$uid][$gid]['subtask'][$pid]['subtask'][$id] = [
                            'id' => $task['id'],
                            'grand_grand_id' => $task['grand_grand_id'],
                            'grand_parent_id' => $task['grand_parent_id'],
                            'grand_id' => $task['grand_id'],
                            'parent_id' => $task['parent_id'],
                            'user_id' => $task['user_id'],
                            'title' => $task['title'],
                            'points' => $task['points'],
                            'progress' => $task['progress'],
                            'is_done' => $task['is_done'],
                            'created_at' => $task['created_at'],
                            'updated_at' => $task['updated_at'],
                            'created_by' => $task['created_by'],
                            'updated_by' => $task['updated_by']
                        ];
                    }
                }
                else
                {
                    $uid = $task['user_id'];
                    $pid = $task['parent_id'];
                    $tasks[$uid][$pid]['subtask'][$task['id']] = [
                        'id' => $task['id'],
                        'grand_grand_id' => $task['grand_grand_id'],
                        'grand_parent_id' => $task['grand_parent_id'],
                        'grand_id' => $task['grand_id'],
                        'parent_id' => $task['parent_id'],
                        'user_id' => $task['user_id'],
                        'title' => $task['title'],
                        'points' => $task['points'],
                        'progress' => $task['progress'],
                        'is_done' => $task['is_done'],
                        'created_at' => $task['created_at'],
                        'updated_at' => $task['updated_at'],
                        'created_by' => $task['created_by'],
                        'updated_by' => $task['updated_by']
                    ];
                }
            }
            else {
                $uid = $task['user_id'];
                $id = $task['id'];
                $tasks[$uid][$id] = [
                    'id' => $task['id'],
                    'grand_grand_id' => $task['grand_grand_id'],
                    'grand_parent_id' => $task['grand_parent_id'],
                    'grand_id' => $task['grand_id'],
                    'parent_id' => $task['parent_id'],
                    'user_id' => $task['user_id'],
                    'title' => $task['title'],
                    'points' => $task['points'],
                    'progress' => $task['progress'],
                    'is_done' => $task['is_done'],
                    'created_at' => $task['created_at'],
                    'updated_at' => $task['updated_at'],
                    'created_by' => $task['created_by'],
                    'updated_by' => $task['updated_by']
                ];
            }
        }

        $tasks = json_decode(json_encode($tasks), TRUE);
        // $this->debug($tasks);

        return view('tasks.dashboard',['tasks' => $tasks, 'users' => $this->users ]);
    }

    public function debug($arg)
    {
        echo '<pre>';
        // $arg = json_decode(json_encode($arg), TRUE);
        print_r($arg);
        echo '</pre>';
        exit;
    }



}
