<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Payment;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    // 購入が完了する
    public function test_user_can_purchase_item()
    {
        $condition = Condition::factory()->create();
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $buyer = User::factory()->create(['email_verified_at' => now()]);

        $item = Item::factory()->create([
            'user_id'      => $seller->id,
            'condition_id' => $condition->id,
            'price'        => 10000,
            'status'       => 'on_sale',
        ]);

        $this->actingAs($buyer);

        session(['payment_method' => 'credit_card', 'item_id' => $item->id]);

        $response = $this->get('/purchase/' . $item->id . '/success');

        $response->assertRedirect('/');
        $this->assertDatabaseHas('payments', [
            'item_id'  => $item->id,
            'buyer_id' => $buyer->id,
        ]);
        $this->assertEquals('sold', $item->fresh()->status);
    }
    // 購入した商品は商品一覧でSOLDと表示される
    public function test_purchased_item_shows_sold_label()
    {
        $condition = Condition::factory()->create();
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $buyer = User::factory()->create(['email_verified_at' => now()]);

        $item = Item::factory()->create([
            'user_id'      => $seller->id,
            'condition_id' => $condition->id,
            'price'        => 10000,
            'status'       => 'sold',
        ]);

        Payment::create([
            'item_id'        => $item->id,
            'buyer_id'       => $buyer->id,
            'amount'         => 10000,
            'payment_method' => 'credit_card',
            'status'         => 'completed',
            'paid_at'        => now(),
        ]);

        $this->actingAs($buyer);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    // 購入した商品がプロフィールの購入した商品一覧に追加されている
    public function test_purchased_item_appears_in_profile()
    {
        $condition = Condition::factory()->create();
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $buyer = User::factory()->create(['email_verified_at' => now()]);

        $item = Item::factory()->create([
            'user_id'      => $seller->id,
            'condition_id' => $condition->id,
            'price'        => 10000,
            'status'       => 'sold',
        ]);

        Payment::create([
            'item_id'        => $item->id,
            'buyer_id'       => $buyer->id,
            'amount'         => 10000,
            'payment_method' => 'credit_card',
            'status'         => 'completed',
            'paid_at'        => now(),
        ]);

        $this->actingAs($buyer);

        $response = $this->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertViewHas('purchases', function ($purchases) use ($item) {
            return $purchases->contains(fn($purchase) => $purchase->item_id === $item->id);
        });
    }
}
