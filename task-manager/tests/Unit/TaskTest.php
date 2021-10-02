<?php

namespace Tests\Unit;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    /**
     * IDを指定してタスクの詳細を取得できることを示すテストです
     */
    public function testTaskGetId() {
        $task = Task::find(2);
        
        $this->assertEquals($task->title, 'テストタスク');
    }

    /**
     * 存在しないIDを指定してタスクが取れないことを示すテスト
     */
    public function testTaskGetFailed() {
        $task = Task::find(0);
        
        $this->assertNull($task);
    }

}
