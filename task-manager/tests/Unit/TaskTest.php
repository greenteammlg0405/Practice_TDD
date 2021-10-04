<?php

namespace Tests\Unit;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * 存在しないIDを指定してタスクが取れないことを示すテスト
     */
    public function testTaskGetFailed() {
        $task = Task::find(0);
        
        $this->assertNull($task);
    }

    public function testUpdate() {
        // taskを新しく作る
        $task = Task::create([
            'title' => 'test',
            'executed' => false,
        ]);

        // タスクタイトルがtestであることを確認
        $this->assertEquals('test', $task->title);
        // タスクの実行が済んでないことを確認
        $this->assertFalse($task->executed);

        // titleにテストを入れてsave
        $task->fill(['title' =>'テスト']);
        $task->save();

        $task2 = Task::find($task->id);
        // テストがtitleに入っている想定でテスト
        $this->assertEquals('テスト', $task2->title);

    }
}
