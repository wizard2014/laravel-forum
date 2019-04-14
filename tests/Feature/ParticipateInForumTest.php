<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function anAuthenticatedUserMayParticipateInForumThreads()
    {
        $user = create('App\User');
        $this->be($user);

        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
             ->assertSee($reply->body);
    }

    /** @test */
    public function unauthenticatedUserMayNotAddReplies()
    {
        $this->withExceptionHandling()
             ->post('/threads/some-channel/1/replies', [])
             ->assertRedirect('/login');
    }

    /** @test */
    public function aRepliesRequiredABody()
    {
        $this->withExceptionHandling()
             ->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply', ['body' => null]);
        $this->post($thread->path() . '/replies', $reply->toArray())
             ->assertSessionHasErrors('body');
    }
}
