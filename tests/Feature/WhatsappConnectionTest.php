<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use App\Models\WhatsappConnection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsappConnectionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Team $team;

    protected function setUp(): void
    {
        parent::setUp();

        $this->team = Team::factory()->create();
        $this->user = User::factory()->create();
        $this->user->teams()->attach($this->team);
    }

    public function test_whatsapp_connection_has_required_fields(): void
    {
        $connection = WhatsappConnection::factory()->create([
            'team_id' => $this->team->id,
        ]);

        $this->assertTrue($connection->instance_name !== null);
        $this->assertTrue($connection->api_key !== null);
        $this->assertEquals('disconnected', $connection->status);
    }

    public function test_whatsapp_connection_is_disconnected_by_default(): void
    {
        $connection = WhatsappConnection::factory()->create([
            'team_id' => $this->team->id,
        ]);

        $this->assertTrue($connection->isDisconnected());
        $this->assertFalse($connection->isConnected());
    }

    public function test_whatsapp_connection_status_methods(): void
    {
        $connection = WhatsappConnection::factory()->create([
            'team_id' => $this->team->id,
            'status' => 'connected',
        ]);

        $this->assertTrue($connection->isConnected());
        $this->assertFalse($connection->isDisconnected());

        $connection->update(['status' => 'connecting']);
        $this->assertTrue($connection->isConnecting());

        $connection->update(['status' => 'error']);
        $this->assertTrue($connection->hasError());
    }

    public function test_whatsapp_connection_belongs_to_team(): void
    {
        $connection = WhatsappConnection::factory()->create([
            'team_id' => $this->team->id,
        ]);

        $this->assertTrue($connection->team->is($this->team));
    }
}
