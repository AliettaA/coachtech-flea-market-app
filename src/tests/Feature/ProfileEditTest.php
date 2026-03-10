<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    // 変更項目が初期値として過去設定されていること
    public function test_profile_edit_displays_current_values()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'name'              => 'テストユーザー',
            'postal_code'       => '123-4567',
            'address'           => '東京都渋谷区',
            'building'          => '渋谷ビル101',
            'profile_image'     => 'profiles/test.jpg',
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('渋谷ビル101');
        $response->assertSee('profiles/test.jpg');
    }
}
