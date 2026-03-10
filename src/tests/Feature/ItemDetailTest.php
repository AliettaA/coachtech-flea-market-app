<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    // 必要な情報が表示される
    public function test_item_detail_displays_all_information()
    {
        $condition = Condition::factory()->create(['name' => '良好']);
        $user = User::factory()->create(['email_verified_at' => now()]);
        $commentUser = User::factory()->create(['email_verified_at' => now()]);

        $item = Item::factory()->create([
            'user_id'      => $user->id,
            'condition_id' => $condition->id,
            'name'         => 'テスト商品',
            'brand'        => 'テストブランド',
            'price'        => 10000,
            'description'  => 'テスト商品説明',
            'status'       => 'on_sale',
        ]);

        // いいね
        Like::create([
            'user_id' => $commentUser->id,
            'item_id' => $item->id,
        ]);

        // コメント
        Comment::create([
            'user_id' => $commentUser->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('10,000');
        $response->assertSee('テスト商品説明');
        $response->assertSee('良好');
        $response->assertSee('テストコメント');
        $response->assertSee($commentUser->name);
    }

    // 複数選択されたカテゴリが表示されている
    public function test_multiple_categories_are_displayed()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);

        $category1 = Category::factory()->create(['name' => 'ファッション']);
        $category2 = Category::factory()->create(['name' => 'ゲーム']);

        $item = Item::factory()->create([
            'user_id'      => $user->id,
            'condition_id' => $condition->id,
            'status'       => 'on_sale',
        ]);

        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('ファッション');
        $response->assertSee('ゲーム');
    }
}
