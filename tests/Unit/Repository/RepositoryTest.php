<?php

namespace Tests\Unit\Repository;

use Illuminate\Database\Eloquent\Builder;
use Tests\TestCase;
use Tests\Unit\Repository\Stub\TestModel;
use Tests\Unit\Repository\Stub\TestRepository;

class RepositoryTest extends TestCase
{
    public function testARepositoryIsCreatedWithItsOwnModel()
    {
        $repository = new TestRepository(
            $model = new TestModel()
        );

        $this->assertEquals($model, $repository->model());
        $this->assertInstanceOf(Builder::class, $originalBuilder = $repository->query());

        $query = $repository->reset();
        $this->assertNotEquals($originalBuilder, $query);
    }

    public function testItCreatesANewModel()
    {
        $repository = new TestRepository(
            new TestModel()
        );

        $mock = $this->mock(TestModel::class);

        $result = $repository->saveModel($mock);

        $this->assertEquals($mock, $result);
    }
}
