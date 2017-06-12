<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_create_new_thread()
    {
        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    public function guest_cannot_see_the_create_thread_page()
    {
        $this->get('threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_title()
    {
        $this->publishThread(['title' => NULL])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_body()
    {
        $this->publishThread(['body' => NULL])->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_valid_channel()
    {
        $this->publishThread(['channel_id' => NULL])->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => 9999])->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
