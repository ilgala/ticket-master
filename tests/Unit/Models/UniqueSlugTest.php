<?php

namespace Tests\Unit\Models;

use App\Models\Department;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UniqueSlugTest extends TestCase
{
    use RefreshDatabase;

    public function testModelWithNotExistingSlugIsCreated()
    {
        $title = 'foo Bar: baz';
        $this->assertDatabaseMissing('tickets', [
            'slug' => 'foo-bar-baz',
        ]);

        $ticket = Ticket::factory()->withMandatoryRelations()->create([
            'title' => $title,
        ]);

        $this->assertEquals('foo-bar-baz', $ticket->slug);
        $this->assertDatabaseHas('tickets', [
            'slug' => 'foo-bar-baz',
        ]);
    }

    public function testModelWithExistingSlugIsCreated()
    {
        $title = 'foo Bar: baz';
        $department = Department::factory()->create();
        Ticket::factory()->withMandatoryRelations($department)->create([
            'title' => $title,
        ]);

        $ticket = Ticket::factory()->withMandatoryRelations($department)->create([
            'title' => $title,
            'slug' => 'foo',
        ]);

        $this->assertEquals('foo-bar-baz-1', $ticket->slug);
        $this->assertDatabaseHas('tickets', [
            'slug' => 'foo-bar-baz-1',
        ]);
    }

    public function testModelWithMultipleExistingSlugIsCreated()
    {
        $title = 'foo Bar: baz';
        $department = Department::factory()->create();
        Ticket::factory()->count(10)->withMandatoryRelations($department)->create([
            'title' => $title,
        ]);

        $ticket = Ticket::factory()->withMandatoryRelations($department)->create([
            'title' => $title,
        ]);

        $this->assertEquals('foo-bar-baz-10', $ticket->slug);
        $this->assertDatabaseHas('tickets', [
            'slug' => 'foo-bar-baz-10',
        ]);

    }
}
