<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/17 0017
 * Time: 16:39
 */
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function guests_can_not_favorite_anything()
    {
        $this->withExceptionHandling()
            ->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }
    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn(); // -->先登录

    $reply = create('App\Reply');

    // If I post a "favorite" endpoint
    $this->post('replies/' . $reply->id . '/favorites');

    // It Should be recorded in the database
    $this->assertCount(1,$reply->favorites);
    }
    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try{
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        }catch (\Exception $e){
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1,$reply->favorites);
    }

}