<?php

namespace Tests\Unit;

use App\Services\WhatsappInstanceService;
use App\Services\EvolutionApiService;
use PHPUnit\Framework\TestCase;

class WhatsappInstanceServiceTest extends TestCase
{
    private WhatsappInstanceService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $evolutionApi = $this->createMock(EvolutionApiService::class);
        $this->service = new WhatsappInstanceService($evolutionApi);
    }

    public function test_map_evolution_status_open_returns_connected(): void
    {
        $this->assertEquals('connected', $this->service->mapEvolutionStatus('open'));
    }

    public function test_map_evolution_status_close_returns_disconnected(): void
    {
        $this->assertEquals('disconnected', $this->service->mapEvolutionStatus('close'));
    }

    public function test_map_evolution_status_closed_returns_disconnected(): void
    {
        $this->assertEquals('disconnected', $this->service->mapEvolutionStatus('closed'));
    }

    public function test_map_evolution_status_connecting_returns_connecting(): void
    {
        $this->assertEquals('connecting', $this->service->mapEvolutionStatus('connecting'));
    }

    public function test_map_evolution_status_qr_returns_qr_code(): void
    {
        $this->assertEquals('qr_code', $this->service->mapEvolutionStatus('qr'));
    }

    public function test_map_evolution_status_unknown_returns_unknown(): void
    {
        $this->assertEquals('unknown', $this->service->mapEvolutionStatus('some_unknown_state'));
    }

    public function test_map_evolution_status_is_case_insensitive(): void
    {
        $this->assertEquals('connected', $this->service->mapEvolutionStatus('OPEN'));
        $this->assertEquals('disconnected', $this->service->mapEvolutionStatus('CLOSE'));
    }
}

