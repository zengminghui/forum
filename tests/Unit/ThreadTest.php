<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->thread = create('App\Thread');
    }
    /** @test */
    function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');

        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}",$thread->path());
    }
    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$this->thread->replies);
    }
    /** @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User',$this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1,$this->thread->replies);
    }
    /** @test */
    function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel',$thread->channel);
    }
    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User',['name' => 'NoNo1']));

        $threadByNoNo1 = create('App\Thread',['user_id' => auth()->id()]);
        $threadNotByNoNo1 = create('App\Thread');

        $this->get('threads?by=NoNo1')
            ->assertSee($threadByNoNo1->title)
            ->assertDontSee($threadNotByNoNo1->title);
    }
}