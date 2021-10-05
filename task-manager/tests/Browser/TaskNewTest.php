<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskNewTest extends DuskTestCase
{
    /**
     * New Task Page Test.
     *
     * @return void
     * @throws \Throwable
     */
    public function testShowNew()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/new')
                    ->assertSee('New Task');
        });
    }

    /**
     * requiredエラーの際のメッセージを確認
     *
     * @return void
     * @throws \Throwable
     */
    public function testShowRequiredValidMessage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/new')
                    ->assertInputValue('#title', '')
                    ->press('登録')
                    ->pause(1000)
                    ->assertPathIs('/tasks/new')
                    ->assertSee('The title field is required.');
        });
    }
}