<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Database\Seeders\ConditionSeeder;



class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ConditionSeeder::class);
    }

    public function test_user_can_purchase_an_item()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post(route('purchase.store', $item->id), [
            'payment_method' => 'card',
            'postcode' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
        ]);
    }

    public function test_purchased_item_is_displayed_as_sold_in_item_list()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => 'テスト商品',
        ]);

        $this->actingAs($user);

        $this->post(route('purchase.store', $item->id), [
            'payment_method' => 'card',
            'postcode' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('sold');
    }

    public function test_purchased_item_is_displayed_in_user_profile()
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

    public function test_selected_payment_method_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('purchase.create', [
            'item' => $item->id,
            'payment_method' => 'card',
        ]));

        $response->assertStatus(200);

        $response->assertSee('カード支払い');
    }

    public function test_updated_address_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create([
            'postcode' => '111-1111',
            'address' => '旧住所',
            'building' => '旧ビル',
        ]);

        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post(route('purchase.address.update', $item->id), [
            'postcode' => '222-2222',
            'address' => '新住所',
            'building' => '新ビル',
        ]);

        $response = $this->get(route('purchase.create', $item->id));

        $response->assertStatus(200);

        $response->assertSee('222-2222');
        $response->assertSee('新住所');
        $response->assertSee('新ビル');
    }

    public function test_address_is_saved_when_item_is_purchased()
    {
        $user = User::factory()->create([
            'postcode' => '222-2222',
            'address' => '新住所',
            'building' => '新ビル',
        ]);

        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post(route('purchase.store', $item->id), [
            'payment_method' => 'card',
            'postcode' => $user->postcode,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'postcode' => '222-2222',
            'address' => '新住所',
            'building' => '新ビル',
        ]);
    }
}
