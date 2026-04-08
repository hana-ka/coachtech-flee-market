<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Database\Seeders\ConditionSeeder;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ConditionSeeder::class);
    }

    public function test_user_profile_information_is_displayed()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => null,
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage');

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');

        $response->assertSee('default.jpeg');
    }

    public function test_user_items_are_displayed_on_profile()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品',
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage');

        $response->assertStatus(200);

        $response->assertSee('出品商品');
    }

    public function test_purchased_items_are_displayed_on_profile()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => '購入商品',
        ]);

        $this->actingAs($user);

        $this->post(route('purchase.store', $item->id), [
            'payment_method' => 'card',
            'postcode' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);

        $response = $this->get('/mypage?page=buy');

        $response->assertStatus(200);

        $response->assertSee('購入商品');
    }

    public function test_profile_edit_form_displays_current_user_information()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'postcode' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
            'profile_image' => null,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('mypage.profile.edit'));

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('テスト住所');
        $response->assertSee('テストビル');

        $response->assertSee('default.jpeg');
    }
}
