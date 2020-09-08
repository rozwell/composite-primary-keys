<?php

namespace MaksimM\CompositePrimaryKeys\Tests;

use MaksimM\CompositePrimaryKeys\Tests\Stubs\TestBinaryUser;
use MaksimM\CompositePrimaryKeys\Tests\Stubs\TestBinaryUserHex;
use MaksimM\CompositePrimaryKeys\Tests\Stubs\TestUser;

class UpdatesTest extends CompositeKeyBaseUnit
{
    /** @test */
    public function validateEmptyCounter()
    {
        /**
         * @var TestUser
         */
        $model = TestUser::find([
            'user_id'         => 1,
            'organization_id' => 100,
        ]);
        $this->assertNotNull($model);
        $this->assertInstanceOf(TestUser::class, $model);
        $this->assertEquals(0, $model->counter);

        return $model;
    }

    /** @test */
    public function validateEmptyCounterBinaryModel()
    {
        /**
         * @var TestBinaryUser
         */
        $model = TestBinaryUser::find([
            'user_id'         => md5(20000, true),
            'organization_id' => 100,
        ]);
        $this->assertNotNull($model);
        $this->assertInstanceOf(TestBinaryUser::class, $model);
        $this->assertEquals(0, $model->counter);

        return $model;
    }

    /** @test */
    public function validateEmptyCounterBinaryModelHex()
    {
        /**
         * @var TestBinaryUserHex
         */
        $model = TestBinaryUserHex::find([
            'user_id'         => md5(20000),
            'organization_id' => 100,
        ]);
        $this->assertNotNull($model);
        $this->assertInstanceOf(TestBinaryUserHex::class, $model);
        $this->assertEquals(0, $model->counter);

        return $model;
    }

    /** @test
     *  @depends validateEmptyCounter
     */
    public function incrementingTest(TestUser $model)
    {
        $model->increment('counter');
        $model->refresh();
        $this->assertEquals(1, $model->counter);

        return $model;
    }

    /** @test
     *  @depends validateEmptyCounter
     */
    public function decrementingTest(TestUser $model)
    {
        $model->decrement('counter');
        $model->refresh();
        $this->assertEquals(-1, $model->counter);
    }

    /** @test
     *  @depends validateEmptyCounterBinaryModel
     */
    public function incrementingBinaryTest(TestBinaryUser $model)
    {
        $model->increment('counter');
        $model->refresh();
        $this->assertEquals(1, $model->counter);

        return $model;
    }

    /** @test
     *  @depends validateEmptyCounterBinaryModel
     */
    public function decrementingBinaryTest(TestBinaryUser $model)
    {
        $model->decrement('counter');
        $model->refresh();
        $this->assertEquals(-1, $model->counter);

        return $model;
    }

    /** @test
     *  @depends validateEmptyCounterBinaryModelHex
     */
    public function incrementingBinaryHexTest(TestBinaryUserHex $model)
    {
        $model->increment('counter');
        $model->refresh();
        $this->assertEquals(1, $model->counter);

        return $model;
    }

    /** @test
     *  @depends validateEmptyCounterBinaryModelHex
     */
    public function decrementingBinaryHexTest(TestBinaryUserHex $model)
    {
        $model->decrement('counter');
        $model->refresh();
        $this->assertEquals(-1, $model->counter);

        return $model;
    }

    /** @test
     *  @depends validateEmptyCounter
     */
    public function updateTest(TestUser $model)
    {
        $model->update([
            'counter' => 9999,
        ]);
        $model->refresh();
        $this->assertEquals(9999, $model->counter);
    }

    /** @test
     *  @depends validateEmptyCounter
     */
    public function saveTest(TestUser $model)
    {
        $this->assertTrue($model->exists);
        $model->counter = 6666;
        $model->save();
        $model->refresh();
        $this->assertEquals(6666, $model->counter);
    }
}
