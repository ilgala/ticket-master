<?php

namespace Tests\Unit\Repository\Stub;

use App\Repositories\Repository;
use Mockery\MockInterface;

class TestRepository extends Repository
{
    public function saveModel(MockInterface $mock)
    {
        $data = ['foo' => 'bar'];
        $mock->expects('fill')
            ->once()
            ->with($data)
            ->andReturnSelf();

        $mock->expects('save')
            ->once()
            ->andReturnSelf();

        return $this->save($mock, $data);
    }
}
