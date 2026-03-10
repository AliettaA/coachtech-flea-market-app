<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Like;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    // いいねした商品だけが表示される
    public function test_only_liked_items_are_displayed()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);

        // いいねした商品
        $likedItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'condition_id' => $condition->id,
            'status' => 'on_sale',
        ]);

        // いいねしていない商品
        Item::factory()->create([
            'user_id' => $otherUser->id,
            'condition_id' => $condition->id,
            'status' => 'on_sale',
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertViewHas('likedItems', function ($likedItems) use ($likedItem) {
            return $likedItems->count() === 1 && $likedItems->first()->id === $likedItem->id;
        });
    }

    // 購入済み商品はSoldと表示される
    public function test_sold_item_displays_sold_label()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);

        $soldItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'condition_id' => $condition->id,
            'status' => 'sold',
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $soldItem->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    // 未認証の場合は何も表示されない
    public function test_guest_sees_no_liked_items()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertViewHas('likedItems', function ($likedItems) {
            return $likedItems->isEmpty();
        });
    }
}
