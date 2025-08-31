<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\RewardController;
use App\Models\Rarity;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RarityLogicTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // レアリティデータ作成
        Rarity::create(['rarity_name' => 'perfect']);
        Rarity::create(['rarity_name' => 'partial']);
        Rarity::create(['rarity_name' => 'fail']);
    }

    // 全タスク達成時にperfectレアリティが返される
    public function perfect_rarity_is_returned_when_all_tasks_completed()
    {
        $controller = new RewardController();
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('determineRarity');
        $method->setAccessible(true);

        $result = $method->invoke($controller, 3, 3);

        $this->assertEquals('perfect', $result->rarity_name);
    }

    // 一部タスク達成時にpartialレアリティが返される
    public function perfect_rarity_is_returned_when_some_tasks_completed()
    {
        $controller = new RewardController();
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('determineRarity');
        $method->setAccessible(true);

        $result = $method->invoke($controller, 2, 3);

        $this->assertEquals('partial', $result->rarity_name);
    }

    // 一部タスク達成時にfailレアリティが返される
    public function perfect_rarity_is_returned_when_no_tasks_completed()
    {
        $controller = new RewardController();
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('determineRarity');
        $method->setAccessible(true);

        $result = $method->invoke($controller, 0, 3);

        $this->assertEquals('fail', $result->rarity_name);
    }

    // タスク数とtrue数が同じ場合はperfect
    public function perfect_rarity_is_returned_when_task_count_equals_true_count()
    {
        $controller = new RewardController();
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('determineRarity');
        $method->setAccessible(true);

        // 1個中1個達成
        $result = $method->invoke($controller, 1, 1);
        $this->assertEquals('perfect', $result->rarity_name);

        // 5個中5個達成
        $result = $method->invoke($controller, 5, 5);
        $this->assertEquals('perfect', $result->rarity_name);
    }
}
