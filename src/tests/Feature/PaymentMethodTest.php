<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    // 支払い方法が正しく反映される
    public function test_payment_method_is_displayed()
    {
        $condition = Condition::factory()->create();
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $buyer = User::factory()->create([
            'email_verified_at' => now(),
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
        ]);

        $item = Item::factory()->create([
            'user_id'      => $seller->id,
            'condition_id' => $condition->id,
            'price'        => 10000,
            'status'       => 'on_sale',
        ]);

        $this->actingAs($buyer);

        $response = $this->get('/purchase/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('クレジットカード');
        $response->assertSee('コンビニ払い');
    }
}
