<?php

namespace Tests\Unit\Services;

use App\Enums\DepartmentCodes;
use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepository;
use App\Services\DepartmentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class DepartmentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testItFindsDepartmentByCode()
    {
        $department = Department::factory()->create();

        /** @var DepartmentRepository|MockInterface $repository */
        $repository = $this->mock(DepartmentRepository::class, function (MockInterface $mock) use ($department) {
            $mock->expects('findBy')
                ->once()
                ->with($department->code)
                ->andReturn($department);
        });

        $service = new DepartmentService($repository);
        $result = $service->findBy($department->code, true);

        $this->assertEquals($department, $result);

        $this->assertEquals($department->getKey(), $result->getKey());
        $this->assertEquals($department->code, $result->code);
    }

    public function testItReturnsNullWhenDepartmentIsNotFound()
    {
        $code = fake()->randomElement(DepartmentCodes::cases());
        $this->assertDatabaseMissing('departments', [
            'code' => $code,
        ]);

        /** @var DepartmentRepository|MockInterface $repository */
        $repository = $this->mock(DepartmentRepository::class, function (MockInterface $mock) use ($code) {
            $mock->expects('findBy')
                ->once()
                ->with($code)
                ->andReturnNull();
        });
        $service = new DepartmentService($repository);

        $result = $service->findBy($code, false);
        $this->assertNull($result);
    }

    public function testItThrowsModelNotFoundExceptionWhenDepartmentIsNotFound()
    {
        $code = fake()->code;
        $this->assertDatabaseMissing('departments', [
            'code' => $code,
        ]);

        /** @var DepartmentRepository|MockInterface $repository */
        $repository = $this->mock(DepartmentRepository::class, function (MockInterface $mock) use ($code) {
            $mock->expects('findBy')
                ->once()
                ->with($code)
                ->andReturnNull();
        });
        $service = new DepartmentService($repository);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage("Can't find department by code $code");

        $service->findBy($code, true);
    }
}
