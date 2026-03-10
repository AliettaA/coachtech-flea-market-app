<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Like;

class LikeActionTest extends TestCase
{
    use RefreshDatabase;

    // いいねができる
    public function test_user_can_like_item()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);

        $item = Item::factory()->create([
            'user_id'      => $otherUser->id,
            'condition_id' => $condition->id,
            'status'       => 'on_sale',
        ]);

        $this->actingAs($user);

        $response = $this->post('/like/' . $item->id);

        $response->assertRedirect();
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->assertEquals(1, $item->fresh()->likes->count());
    }

    // いいね済みのアイコンは色が変化する
    public function test_liked_item_shows_active_icon()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);

        $item = Item::factory()->create([
            'user_id'      => $otherUser->id,
            'condition_id' => $condition->id,
            'status'       => 'on_sale',
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('item-detail__like-btn--active');
    }

    // いいねを解除できる
    public function test_user_can_unlike_item()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);

        $item = Item::factory()->create([
            'user_id'      => $otherUser->id,
            'condition_id' => $condition->id,
            'status'       => 'on_sale',
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->delete('/like/' . $item->id);

        $response->assertRedirect();
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->assertEquals(0, $item->fresh()->likes->count());
    }
}
