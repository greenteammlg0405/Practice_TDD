<?php

namespace Tests\Browser;

use App\Task;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TasksIndexTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $task;

    // setupはprotected
    protected function setup() {
        parent::setUp();
        $this->task = Task::create([
            'title' => 'テストタスク',
            'executed' => false,
        ]);
    }

    /**
     * インデックスから詳細に飛ぶテスト
     */
    public function testIndexToDetail() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks')
            ->assertSeeLink('テストタスク')
            ->clickLink('テストタスク')
            ->waitForLocation('/tasks/' . $this->task->id, 1)
            ->assertPathIs('/tasks/' . $this->task->id)
            ->assertInputValue('#title', 'テストタスク');
        });
    }   
}
