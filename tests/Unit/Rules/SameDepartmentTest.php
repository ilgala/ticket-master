<?php

namespace Tests\Unit\Rules;

use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use App\Rules\SameDepartment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SameDepartmentTest extends TestCase
{
    use RefreshDatabase;

    public function testValidationFailsWithDifferentDepartments()
    {
        $user = User::factory()->create();
        $comm = Department::factory()
            ->comm()
            ->create();
        $admin = Department::factory()
            ->admin()
            ->create();
        $admin->users()->attach($user->getKey());

        $ticket = Ticket::factory()
            ->withMandatoryRelations($comm)
            ->create();

        $rule = new SameDepartment($user->email);

        $this->expectException(\RuntimeException::class);
        $rule->validate('ticket', $ticket->getKey(), function ($message) {
            $this->assertEquals('Department doesn\'t match for the given ticket and assignee', $message);
            throw new \RuntimeException('message');
        });
    }

    public function testValidationPassesWithSameDepartment()
    {
        $user = User::factory()->create();
        $comm = Department::factory()
            ->comm()
            ->create();
        $comm->users()->attach($user->getKey());

        $ticket = Ticket::factory()
            ->withMandatoryRelations($comm)
            ->create();

        $rule = new SameDepartment($user->email);
        $rule->validate('ticket', $ticket->getKey(), function ($message) {
            $this->assertEquals('Department doesn\'t match for the given ticket and assignee', $message);
            throw new \RuntimeException('message');
        });

        $this->assertTrue(true);
    }
}
