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
}
