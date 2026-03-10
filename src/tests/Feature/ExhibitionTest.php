<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Condition;
use App\Models\Category;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    // 商品出品画面にて必要な情報が保存できる
    public function test_user_can_exhibit_item()
    {
        Storage::fake('public');

        $condition = Condition::factory()->create();
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($user);

        $response = $this->post('/sell', [
            'name'         => 'テスト商品',
            'brand'        => 'テストブランド',
            'description'  => 'テスト商品説明',
            'price'        => 10000,
            'condition_id' => $condition->id,
            'category_id'  => [$category1->id, $category2->id],
            'image'        => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('items', [
            'name'         => 'テスト商品',
            'brand'        => 'テストブランド',
            'description'  => 'テスト商品説明',
            'price'        => 10000,
            'condition_id' => $condition->id,
            'user_id'      => $user->id,
        ]);

        // カテゴリが正しく紐づいているか確認
        $item = \App\Models\Item::where('name', 'テスト商品')->first();
        $this->assertTrue($item->categories->contains($category1->id));
        $this->assertTrue($item->categories->contains($category2->id));
    }
}
