<?php

namespace Tests\Browser;

use App\Task;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskDetailTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $task;

    protected function setUp()
    {
        parent::setUp();
        $this->task = Task::create([
            'title' => 'テストタスク',
            'executed' => false,
        ]);
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/' . $this->task->id)
                ->assertInputValue('#title', 'テストタスク')
                ->screenshot('task_detail');
        });
    }

    /**
     * Task Post Test.
     *
     * @throws \Throwable
     */
    public function testPost()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/' . $this->task->id)
                ->assertInputValue('#title', 'テストタスク')
                ->type('#title', 'test task')
                ->screenshot('task_post_typed')
                ->press('更新')
                ->pause(1000)
                ->assertPathIs('/tasks/' . $this->task->id)
                ->assertInputValue('#title', 'test task')
                ->screenshot('task_post_pressed');
        });
    }
}
