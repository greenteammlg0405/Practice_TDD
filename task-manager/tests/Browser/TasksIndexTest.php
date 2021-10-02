<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TasksIndexTest extends DuskTestCase
{

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks')
                ->assertSee('テストタスク')
                ->screenshot("tasks_index");
        });
    }

    /**
     * インデックスから詳細に飛ぶテスト
     */
    public function testIndexToDetail() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks')
                ->assertSeeLink('テストタスク')
                ->clickLink('テストタスク')
                ->waitForLocation('/tasks/2', 1)
                ->assertPathIs('/tasks/2')
                ->assertSee('テストタスク');
        });
    }
}
