<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Like;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    // 商品名で部分一致検索ができる
    public function test_items_can_be_searched_by_partial_name()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);

        Item::factory()->create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'status' => 'on_sale',
        ]);

        Item::factory()->create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => '別の商品',
            'status' => 'on_sale',
        ]);

        $otherUser = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($otherUser);

        $response = $this->get('/?search=テスト');

        $response->assertStatus(200);
        $response->assertViewHas('items', function ($items) {
            return $items->count() === 1 && $items->first()->name === 'テスト商品';
        });
    }

    // 検索状態がマイリストでも保持されている
    public function test_search_keyword_is_retained_in_mylist()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);

        $item = Item::factory()->create([
            'user_id' => $otherUser->id,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'status' => 'on_sale',
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist&search=テスト');

        $response->assertStatus(200);
        $response->assertViewHas('likedItems', function ($likedItems) {
            return $likedItems->count() === 1 && $likedItems->first()->name === 'テスト商品';
        });
    }
}
