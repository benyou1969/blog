<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadCommentsTest extends TestCase
{
    /**
     * A user can read comments
     *
     * @return void
     */
    use DatabaseMigrations;
    public function setUp()
    {
        parent::setUp();
        $this->post = factory('App\Post')->create();
        $this->comment = factory('App\Comment')->create(['post_id' => $this->post->id]);
    }
    public function test_a_user_can_see_all_comments()
    {
        $response = $this->get($this->post->path())
        ->assertSee($this->comment->body);
    }
}
