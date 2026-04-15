<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\WhatsappConnection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<WhatsappConnection>
 */
class WhatsappConnectionFactory extends Factory
{
    protected $model = WhatsappConnection::class;

    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'instance_name' => 'instance-'.Str::random(8),
            'evolution_instance_id' => Str::uuid(),
            'api_key' => Str::random(32),
            'phone_number' => $this->faker->phoneNumber(),
            'profile_name' => $this->faker->name(),
            'status' => 'disconnected',
            'settings' => [
                'rejectCall' => true,
                'groupsIgnore' => false,
                'alwaysOnline' => true,
            ],
        ];
    }

    public function connected(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'connected',
                'connected_at' => now(),
            ];
        });
    }

    public function connecting(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'connecting',
            ];
        });
    }

    public function error(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'error',
                'error_message' => 'Connection timeout',
            ];
        });
    }
}
