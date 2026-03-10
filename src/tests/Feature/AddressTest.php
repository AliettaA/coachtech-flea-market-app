<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Payment;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    // 登録した住所が商品購入画面に反映される
    public function test_updated_address_is_reflected_in_purchase_page()
    {
        $condition = Condition::factory()->create();
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $buyer = User::factory()->create([
            'email_verified_at' => now(),
            'postal_code'       => '123-4567',
            'address'           => '東京都渋谷区',
            'building'          => '渋谷ビル101',
        ]);

        $item = Item::factory()->create([
            'user_id'      => $seller->id,
            'condition_id' => $condition->id,
            'status'       => 'on_sale',
        ]);

        $this->actingAs($buyer);

        // 住所変更
        $this->post('/purchase/address/' . $item->id, [
            'postal_code' => '987-6543',
            'address'     => '大阪府大阪市',
            'building'    => '大阪ビル202',
        ]);

        // 購入画面で反映確認
        $response = $this->get('/purchase/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('987-6543');
        $response->assertSee('大阪府大阪市');
        $response->assertSee('大阪ビル202');
    }

    // 購入した商品に送付先住所が紐づいて登録される
    public function test_address_is_associated_with_purchase()
    {
        $condition = Condition::factory()->create();
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $buyer = User::factory()->create([
            'email_verified_at' => now(),
            'postal_code'       => '123-4567',
            'address'           => '東京都渋谷区',
            'building'          => '渋谷ビル101',
        ]);

        $item = Item::factory()->create([
            'user_id'      => $seller->id,
            'condition_id' => $condition->id,
            'price'        => 10000,
            'status'       => 'on_sale',
        ]);

        $this->actingAs($buyer);

        // 住所変更
        $this->post('/purchase/address/' . $item->id, [
            'postal_code' => '987-6543',
            'address'     => '大阪府大阪市',
            'building'    => '大阪ビル202',
        ]);

        // 購入完了
        session(['payment_method' => 'credit_card', 'item_id' => $item->id]);
        $this->get('/purchase/' . $item->id . '/success');

        // 住所が正しく紐づいているか確認
        $this->assertDatabaseHas('users', [
            'id'          => $buyer->id,
            'postal_code' => '987-6543',
            'address'     => '大阪府大阪市',
            'building'    => '大阪ビル202',
        ]);

        $this->assertDatabaseHas('payments', [
            'item_id'  => $item->id,
            'buyer_id' => $buyer->id,
        ]);
    }
}
