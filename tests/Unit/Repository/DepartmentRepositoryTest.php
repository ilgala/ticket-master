<?php

namespace Tests\Unit\Repository;

use App\Enums\DepartmentCodes;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public static function codesProvider(): array
    {
        return array_map(fn (DepartmentCodes $code) => [$code], DepartmentCodes::cases());
    }

    public function testItFindsADepartmentByCode()
    {
        $user = Department::factory()->create();
        $repository = new DepartmentRepository();

        $result = $repository->findBy($user->code);

        $this->assertEquals($user->getKey(), $result->getKey());
        $this->assertEquals($user->code, $result->code);
    }

    /**
     * @dataProvider codesProvider
     */
    public function testItReturnsNullWhenDepartmentIsNotFound(DepartmentCodes $code)
    {
        $repository = new DepartmentRepository();

        $user = $repository->findBy($code);

        $this->assertNull($user);
    }
}
