<?php

namespace Tests\Feature;

use App\Task;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use RefreshDatabase;

    private $task;

    protected function setUp() {
        parent::setUp();

        $this->task = Task::create([
            'title' => 'テストタスク',
            'executed' => false
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetRoutePath()
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
    }
     
    /**
     * detailのpath確認test
     *
     * @return void
     */
    public function testDetailPath()
    {
        $response = $this->get('/tasks/' . $this->task->id);
        $response->assertStatus(200);
    }


    /**
     * detailのidが存在しない場合、404に飛ぶというテスト
     *
     * @return void
     */
    public function testDetailPathGetFailed()
    {
        $response = $this->get('/tasks/0');
        $response->assertStatus(404);
    }

    /**
     * updateのURLにアクセスした際にリダイレクトするテスト
     *
     * @return void
     */
    public function testUpdatePath()
    {
        $data = [
            'title' => 'test title 2',
        ];
        // tasksがDBにないことを確認
        $this->assertDatabaseMissing('tasks', $data);

        $response = $this->put('/tasks/' . $this->task->id, $data);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/' . $this->task->id);

        $this->assertDatabaseHas('tasks', $data);
  
    }

    public function testPutTaskPath2()
    {
        $data = [
            'title' => 'テストタスク2',
            'executed' => true,
        ];
        $this->assertDatabaseMissing('tasks', $data);

        $response = $this->put('/tasks/' . $this->task->id, $data);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/' . $this->task->id);

        $this->assertDatabaseHas('tasks', $data);
    }
}
