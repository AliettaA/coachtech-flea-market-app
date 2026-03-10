<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Payment;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    // 必要な情報が取得できる
    public function test_user_profile_displays_all_information()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'name'              => 'テストユーザー',
            'profile_image'     => 'profiles/test.jpg',
        ]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);

        // 出品した商品
        $soldItem = Item::factory()->create([
            'user_id'      => $user->id,
            'condition_id' => $condition->id,
            'name'         => '出品した商品',
            'status'       => 'on_sale',
        ]);

        // 購入した商品
        $purchasedItem = Item::factory()->create([
            'user_id'      => $otherUser->id,
            'condition_id' => $condition->id,
            'name'         => '購入した商品',
            'price'        => 10000,
            'status'       => 'sold',
        ]);

        Payment::create([
            'item_id'        => $purchasedItem->id,
            'buyer_id'       => $user->id,
            'amount'         => 10000,
            'payment_method' => 'credit_card',
            'status'         => 'completed',
            'paid_at'        => now(),
        ]);

        $this->actingAs($user);

        // 出品した商品一覧
        $response = $this->get('/mypage?page=sell');
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('出品した商品');

        // 購入した商品一覧
        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSee('購入した商品');
    }
}
