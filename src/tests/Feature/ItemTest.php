<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    // 全商品を取得できる
    public function test_all_items_are_displayed()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);

        Item::factory()->count(5)->create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'status' => 'on_sale',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('items', function ($items) {
            return $items->count() === 5;
        });
    }

    // 購入済み商品はSoldと表示される
    public function test_sold_item_displays_sold_label()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'status' => 'sold',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    // 自分が出品した商品は表示されない
    public function test_own_items_are_not_displayed()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);

        // 自分の商品
        Item::factory()->create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => '自分の商品',
            'status' => 'on_sale',
        ]);

        // 他のユーザーの商品
        Item::factory()->create([
            'user_id' => $otherUser->id,
            'condition_id' => $condition->id,
            'name' => '他のユーザーの商品',
            'status' => 'on_sale',
        ]);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('items', function ($items) {
            return $items->every(fn($item) => $item->name !== '自分の商品');
        });
    }
}
