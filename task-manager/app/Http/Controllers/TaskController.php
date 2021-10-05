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
            $fillData['executed'] = 1;
        }

        if (count($fillData) > 0) {
            $task->fill($fillData);
            $task->save();
        }

        return redirect('/tasks/' . $id);
    }

    /**
     * 新規作成画面への遷移
     */
    public function new()
    {
        return view('new');
    }

    /**
     * 新規作成する関数
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:512',
        ]);

        $response = Task::create([
            'title' => $request->title,
            'executed' => false
        ]);
        
        // 意図的にリダイレクトにしている
        return redirect('/tasks');
    }

    /**
     * 削除する関数
     */
    public function remove($id)
    {
        Task::destroy($id);
        
        // 意図的にリダイレクトにしている
        return redirect('/tasks');
    }
}
