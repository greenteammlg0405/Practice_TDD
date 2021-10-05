<?php

namespace Tests\Browser;

use App\Task;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskDeleteTest extends DuskTestCase
{
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
     * Delete Task Test.
     *
     * @return void
     * @throws \Throwable
     */
    public function testPushDelete()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/' . $this->task->id)
                ->press('削除')
                ->pause(1000)
                ->assertPathIs('/tasks');
        });
    }
}