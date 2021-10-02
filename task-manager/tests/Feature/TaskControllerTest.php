<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
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
        $response = $this->get('/tasks/1');
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
}
