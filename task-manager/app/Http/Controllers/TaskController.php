<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function index()
    {
        $tasks = Task::all();
        
        return view('index', compact('tasks'));
    }

    // taskの詳細を表示する関数
    public function detail(int $id)
    {
        
        // $task = (object)[
        //     'id' => 2,
        //     'title' => 'テストタスク',
        //     'executed' => false
        // ];
        $task = Task::find($id);
        if (is_null($task)) {
            abort(404);
        }
        return view('detail', compact('task'));
    }

    /**
     * putでupdateする関数
     */
    public function update(int $id, Request $request)
    {
        $task = Task::find($id);
        if ($task === null) {
            abort(404);
        }

        $fillData = [];
        if (isset($request->title)) {
            $fillData['title'] = $request->title;
        }
        if (isset($request->executed)) {
            $fillData['executed'] = $request->executed;
        }

        if (count($fillData) > 0) {
            $task->fill($fillData);
            $task->save();
        }

        return redirect('/tasks/' . $id);
    }
}
