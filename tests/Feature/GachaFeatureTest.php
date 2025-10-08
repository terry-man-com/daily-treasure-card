<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Child;
use App\Models\Item;
use App\Models\Rarity;
use App\Models\Category;
use App\Models\ChildRewardCollection;

class GachaFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createTestData();
    }

    /** @test */
    /** 認証済みユーザーがガチャを引くことができる */
    public function authenticated_user_can_draw_gacha()
    {
        $user = User::factory()->create();
        $child = Child::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->postJson("/gacha/draw", [
                'child_id' => $child->id,
                'true_count' => 3,
                'total_tasks' => 3
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'item' => ['id', 'item_name', 'item_image_path'],
                'rarity',
                'earned_at'
            ]);

        $this->assertDatabaseHas('child_reward_collections', [
            'child_id' => $child->id
        ]);
    }

    /** @test */
    public function perfect_item_is_awarded_when_all_tasks_completed()
    {
        $user = User::factory()->create();
        $child = Child::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->postJson("/gacha/draw", [
                'child_id' => $child->id,
                'true_count' => 3,
                'total_tasks' => 3
            ]);

        $response->assertStatus(200)
            ->assertJson(['rarity' => 'perfect']);
    }

    /** @test */
    // 一部タスク未達成時にpartialアイテムが当たる
    public function perfect_item_is_awarded_when_some_tasks_completed()
    {
        $user = User::factory()->create();
        $child = Child::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->postJson("/gacha/draw", [
                'child_id' => $child->id,
                'true_count' => 2,
                'total_tasks' => 3
            ]);

        $response->assertStatus(200)
            ->assertJson(['rarity' => 'partial']);
    }

    /** @test */
    // 全タスク未達成時にfailアイテムが当たる
    public function perfect_item_is_awarded_when_no_tasks_completed()
    {
        $user = User::factory()->create();
        $child = Child::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->postJson("/gacha/draw", [
                'child_id' => $child->id,
                'true_count' => 0,
                'total_tasks' => 3
            ]);

        $response->assertStatus(200)
            ->assertJson(['rarity' => 'fail']);
    }

    /** @test */
    // 未認証ユーザーはガチャを引けない
    public function unauthenticated_user_cannot_draw_gacha()
    {
        // 未認証ユーザーはガチャを引けない
        $child = Child::factory()->create();

        $response = $this->postJson("/gacha/draw", [
            'child_id' => $child->id,
            'true_count' => 3,
            'total_tasks' => 3
        ]);
        // 401は認証エラーを示すエラーコード
        $response->assertStatus(401);
    }

    /** @test */
    // 他人の子どもでガチャを引けない
    public function user_cannot_draw_gacha_for_other_users_child()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $child = Child::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)
            ->postJson("/gacha/draw", [
                'child_id' => $child->id,
                'true_count' => 3,
                'total_tasks' => 3
            ]);
        
        $response->assertStatus(404);
    }

    /** @test */
    // 不正な値でエラーになる
    public function validation_error_occurs_with_invalid_parameters()
    {
        $user = User::factory()->create();
        $child = Child::factory()->create(['user_id' => $user->id]);

        // true_countが負の数
        $response = $this->actingAs($user)
            ->postJson("/gacha/draw", [
                'child_id' => $child->id,
                'true_count' => -1,
                'total_tasks' => 3
            ]);

        $response->assertStatus(422);

        // total_tasksが0
        $response = $this->actingAs($user)
            ->postJson("/gacha/draw", [
                'child_id' => $child->id,
                'true_count' => 1,
                'total_tasks' => 0
            ]);

        $response->assertStatus(422);
    }

    /** @test */
    // 景品履歴ページが正しく表示される
    public function reward_history_page_displays_correctly()
    {
        $user = User::factory()->create();
        $child = Child::factory()->create(['user_id' => $user->id]);

        // 完全なテストデータを作成
        $category = Category::create(['category_name' => 'かわいい']);
        $rarity = Rarity::create(['rarity_name' => 'perfect']);
        $item = Item::create([
            'item_name' => 'テストユニコーン',
            'item_image_path' => '/test/unicorn.png',
            'category_id' => $category->id,
            'rarity_id' => $rarity->id
        ]);

        // テスト用の景品履歴を作成（item_id も指定）
        ChildRewardCollection::factory()->create([
            'child_id' => $child->id,
            'item_id' => $item->id,
            'earned_at' => now()
        ]);

        $response = $this->actingAs($user)
            ->get("/rewards");

        $response->assertStatus(200)
            ->assertViewIs('rewards.index')
            ->assertViewHas('selectedChild', $child);
    }

    /** @test */
    // アイテムが生成されるか確認。
    private function createTestData()
    {
        // カテゴリ作成
        $cuteCategory = Category::create(['category_name' => 'かわいい']);
        $coolCategory = Category::create(['category_name' => 'かっこいい']);
        $failCategory = Category::create(['category_name' => 'ハズレ']);

        // レアリティ作成
        $perfectRarity = Rarity::create(['rarity_name' => 'perfect']);
        $partialRarity = Rarity::create(['rarity_name' => 'partial']);
        $failRarity = Rarity::create(['rarity_name' => 'fail']);

        // アイテム作成
        Item::create([
            'item_name' => 'テストユニコーン',
            'item_image_path' => '/test/unicorn.png',
            'category_id' => $cuteCategory->id,
            'rarity_id' => $perfectRarity->id
        ]);

        Item::create([
            'item_name' => 'テスト宝石',
            'item_image_path' => '/test/gem.png',
            'category_id' => $cuteCategory->id,
            'rarity_id' => $partialRarity->id
        ]);

        Item::create([
            'item_name' => 'テストカプセル',
            'item_image_path' => '/test/capsule.png',
            'category_id' => $failCategory->id,
            'rarity_id' => $failRarity->id
        ]);
    }
    
    /** @test */
    // ガチャを１日複数回引けるか確認。
    // 仕様：ガチャは１日複数回引ける。１回目はinsert,以降はupdateされる
    public function user_can_draw_gacha_multiple_times_per_day_with_update()
    {
        $this->markTestSkipped('SQLite環境では日別更新制限のテストをスキップ。システムテストで確認。');
        $user = User::factory()->create();
        $child = Child::factory()->create(['user_id' => $user->id]);

        // １回目のガチャ（新規作成）
        $firstResponse = $this->actingAs($user)
            ->postJson("/gacha/draw", [
                'child_id' => $child->id,
                'true_count' => 3,
                'total_tasks' => 3
            ]);

        $firstResponse->assertStatus(200)
            ->assertJson([
                'is_new' => true,
                'message' => '今日の宝物をゲット！'
            ]);

        $firstItemId = $firstResponse->json('item.id');

        // 2回目のガチャ（同日・更新）
        $secondResponse = $this->actingAs($user)
            ->postJson("/gacha/draw", [
                'child_id' => $child->id,
                'true_count' => 1, // partial
                'total_tasks' => 3
            ]);

        $secondResponse->assertStatus(200)
            ->assertJson([
                'is_new' => false,
                'message' => '今日の宝物を更新しました！'
            ]);

        $secondItemId = $secondResponse->json('item.id');

        // データベース確認：1件のみ存在
        $this->assertDatabaseCount('child_reward_collections', 1);

        // 最新のアイテムで更新されている
        $this->assertDatabaseHas('child_reward_collections', [
            'child_id' => $child->id,
            'item_id' => $secondItemId, // ２回目のアイテム
        ]);

        // 1回目のアイテムは存在しない（更新されたため）
        $this->assertDatabaseMissing('child_reward_collections', [
            'child_id' => $child->id,
            'item_id' => $firstItemId,
        ]);
    }

    /** @test */
    // 異なる日であれば新規レコードが作成される
    public function user_can_draw_gacha_on_different_days()
    {
        $this->markTestSkipped('SQLite環境では日別更新制限のテストをスキップ。システムテストで確認。');
        $user = User::factory()->create();
        $child = Child::factory()->create(['user_id' => $user->id]);

        // テストのために前日のガチャを作成
        $item = Item::first(); // テストデータで作成済みのアイテムを取得

        $yesterdayReward = ChildRewardCollection::factory()->create([
            'child_id' => $child->id,
            'item_id' => $item->id,
            'earned_at' => now()->subDay(),
        ]);

        // 今日のガチャ（新規作成されるはず）
        $response = $this->actingAs($user)
            ->postJson("/gacha/draw", [
                'child_id' => $child->id,
                'true_count' => 3,
                'total_tasks' => 3
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'is_new' => true,
                'message' => '今日の宝物をゲット！'
            ]);

        // データベース確認：2件存在（昨日分 + 今日分）
        $this->assertDatabaseCount('child_reward_collections', 2);

        // 昨日のレコードは変更されていない
        $this->assertDatabaseHas('child_reward_collections', [
            'id' => $yesterdayReward->id,
            'child_id' => $child->id,
        ]);
    }
}