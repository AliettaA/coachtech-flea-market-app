<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    // ログイン済みのユーザーはコメントを送信できる
    public function test_authenticated_user_can_post_comment()
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

        $response = $this->post('/comment/' . $item->id, [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }

    // ログイン前のユーザーはコメントを送信できない
    public function test_guest_cannot_post_comment()
    {
        $condition = Condition::factory()->create();
        $user = User::factory()->create(['email_verified_at' => now()]);

        $item = Item::factory()->create([
            'user_id'      => $user->id,
            'condition_id' => $condition->id,
            'status'       => 'on_sale',
        ]);

        $response = $this->post('/comment/' . $item->id, [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }

    // コメントが入力されていない場合バリデーションメッセージが表示される
    public function test_comment_is_required()
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

        $response = $this->post('/comment/' . $item->id, [
            'content' => '',
        ]);

        $response->assertSessionHasErrors(['content']);
    }

    // コメントが255文字以上の場合バリデーションメッセージが表示される
    public function test_comment_max_length()
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

        $response = $this->post('/comment/' . $item->id, [
            'content' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors(['content']);
    }
}
