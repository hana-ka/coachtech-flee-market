<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use Database\Seeders\ConditionSeeder;
use \App\Models\Purchase;
use \App\Models\User;
use \App\Models\Like;
use App\Models\Category;
use App\Models\Comment;
use \App\Models\Condition;
use Database\Seeders\CategorySeeder;
use Illuminate\Http\UploadedFile;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ConditionSeeder::class);
        $this->seed(CategorySeeder::class);

    }


    public function test_all_items_are_displayed()
    {

        $items = Item::factory()->count(3)->create();

        $response = $this->get('/');

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    public function test_sold_item_is_displayed_as_sold()
    {

        $item = Item::factory()->create();

        Purchase::factory()->create([
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('Sold');
    }

    public function test_user_cannot_see_own_items()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertDontSee('自分の商品');
    }

    public function test_only_liked_items_are_displayed_in_mylist()
    {
        $user = User::factory()->create();

        $item1 = Item::factory()->create([
            'name' => 'いいね商品',
        ]);

        $item2 = Item::factory()->create([
            'name' => 'いいねしてない商品',
        ]);

        Like::create([
        'user_id' => $user->id,
        'item_id' => $item1->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertSee('いいね商品');
        $response->assertDontSee('いいねしてない商品');
    }

    public function test_sold_label_is_displayed_for_purchased_items_in_mylist()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => '購入済み商品',
        ]);

        Purchase::factory()->create([
            'item_id' => $item->id,
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertSee('Sold');
    }

    public function test_guest_sees_no_items_in_mylist()
    {
        $item = Item::factory()->create([
            'name' => 'テスト',
        ]);

        Like::create([
            'user_id' => User::factory()->create()->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertDontSee($item->name);
    }

    public function test_items_can_be_searched_by_partial_name()
    {
        Item::factory()->create([
            'name' => '赤いバッグ',
        ]);

        Item::factory()->create([
            'name' => '青い靴',
        ]);

        Item::factory()->create([
            'name' => '赤い靴',
        ]);

        $response = $this->get('/?keyword=赤');

        $response->assertStatus(200);

        $response->assertSee('赤いバッグ');
        $response->assertSee('赤い靴');
        $response->assertDontSee('青い靴');
    }

    public function test_search_keyword_is_preserved_in_mylist()
    {
        $user = User::factory()->create();

        $item1 = Item::factory()->create([
            'name' => '赤いバッグ',
        ]);

        $item2 = Item::factory()->create([
            'name' => '青い靴',
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item1->id,
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item2->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist&keyword=赤');

        $response->assertStatus(200);

        $response->assertSee('赤いバッグ');
        $response->assertDontSee('青い靴');

        $response->assertSee('name="keyword"', false);
        $response->assertSee('value="赤"', false);
    }

    public function test_item_detail_displays_all_required_information()
    {
        $user = User::factory()->create();

        $condition = Condition::first();

        $category = Category::first();

        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => '1000',
            'description' => 'これはテスト用の商品説明です',
            'image' => 'test.jpg',
        ]);

        $item->categories()->attach($category->id);

        Like::insert([
            [
                'user_id' => $user->id,
                'item_id' => $item->id,
            ],
            [
                'user_id' => User::factory()->create()->id,
                'item_id' => $item->id,
            ],
        ]);

        Comment::insert([
            [
                'user_id' => $user->id,
                'item_id' => $item->id,
                'content' => 'コメントA',
            ],
            [
                'user_id' => User::factory()->create()->id,
                'item_id' => $item->id,
                'content' => 'コメントB',
            ],
            [
                'user_id' => User::factory()->create()->id,
                'item_id' => $item->id,
                'content' => 'コメントC',
            ],
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('¥');
        $response->assertSee('1,000');
        $response->assertSee('これはテスト用の商品説明です');

        $response->assertSee('カテゴリ');
        $response->assertSee($category->name);

        $response->assertSee('商品の状態');
        $response->assertSee($condition->name);

        $response->assertSee('コメントA');
        $response->assertSee('コメントB');
        $response->assertSee('コメントC');

        $response->assertSee($user->name);

        $response->assertSee('test.jpg');

        $response->assertSee('コメント  (3)');

        $response->assertSee('2');
    }

    public function test_multiple_categories_are_displayed_in_item_detail()
    {
        $categories = Category::take(2)->get();

        $item = Item::factory()->create();

        $item->categories()->attach($categories->pluck('id'));

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }

    public function test_user_can_like_an_item_and_like_count_increases()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->assertDatabaseCount('likes', 0);

        $this->post("/like/{$item->id}");

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('1');
    }

    public function test_liked_item_shows_colored_heart_icon()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('icon-heart-pink.png');
    }

    public function test_user_can_unlike_an_item_and_like_count_decreases()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $this->post("/like/{$item->id}");

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('0');
    }

    public function test_user_can_post_comment_and_count_increases()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post("/comment/{$item->id}", [
            'content' => 'テストコメント',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertSee('コメント  (1)');
        $response->assertSee('テストコメント');
    }

    public function test_guest_cannot_post_comment()
    {
        $item = Item::factory()->create();

        $this->post("/comment/{$item->id}", [
            'content' => 'テストコメント',
        ]);

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_error_message_is_displayed_when_comment_is_empty()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/comment/{$item->id}", [
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');

        $response = $this->get("/item/{$item->id}");
        $response->assertSee('コメントを入力してください');
    }

    public function test_error_message_is_displayed_when_comment_exceeds_255_characters()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $this->actingAs($user);

        $longText = str_repeat('あ', 256);

        $response = $this->post("/comment/{$item->id}", [
            'content' => $longText,
        ]);

        $response->assertSessionHasErrors('content');

        $response = $this->get("/item/{$item->id}");
        $response->assertSee('255文字以内で入力してください');
    }

    public function test_user_can_store_item_with_all_required_information()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $condition = Condition::first();
        $category = Category::first();

        $response = $this->post(route('items.store'), [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 1000,
            'condition_id' => $condition->id,
            'categories' => [$category->id],
            'image' => UploadedFile::fake()->create('test.jpg'),
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 1000,
            'condition_id' => $condition->id,
            'user_id' => $user->id,
        ]);

        $item = Item::first();

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);
    }
}
