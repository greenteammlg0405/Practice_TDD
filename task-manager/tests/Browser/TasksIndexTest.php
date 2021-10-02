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
}
