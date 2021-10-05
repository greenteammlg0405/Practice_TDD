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

    /**
     * updateできることを確認
     */
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

    /**
     * 新規作成画面へ遷移できること
     * @return void
     */
    public function testIndexToNew()
    {
        $response = $this->get('/tasks/new');
        $response->assertStatus(200);
    }

    /**
     * Post Task Path Test
     * 新規作成が正常に行えることを示すテスト
     *
     * @return void
     */
    public function testPostTaskPath()
    {
        $data = [
            'title' => 'test title',
        ];
        $this->assertDatabaseMissing('tasks', $data);

        $response = $this->post('/tasks/', $data);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/');

        $this->assertDatabaseHas('tasks', $data);
    }


    /**
     * Post validatation test
     * タイトルは必須なのでバリデーションで弾かれるテスト
     *
     * @return void
     */
    public function testPostValidation_required()
    {
        $data = [];

        $response = $this->from('tasks/new')->post('/tasks/', $data);

        $response->assertSessionHasErrors(['title' => 'The title field is required.']);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/new');
    }

    /**
     * Post validatation test
     * 512文字以上なのでバリデーションで弾かれるテスト
     *
     * @return void
     */
    public function testPostValidation_string513()
    {
        $data = [
            'title' => str_random(513)
        ];

        // tasksにpostすることで新規作成routeを叩く
        $response = $this->from('/tasks/new')->post('/tasks/', $data);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/new');

        $response->assertSessionHasErrors(['title' => 'The title may not be greater than 512 characters.']);
    }

    /**
     * Post validatation test
     * 512文字以下なので登録できることが確認できるテスト
     * @return void
     */
    public function testPostValidation_string512()
    {
        $data = [
            'title' => str_random(512)
        ];

        // tasksにpostすることで新規作成routeを叩く
        $response = $this->post('/tasks/', $data);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/');

        $this->assertDatabaseHas('tasks', $data);
    }
}
