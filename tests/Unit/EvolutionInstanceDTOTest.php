<?php

namespace Tests\Unit;

use App\DTOs\EvolutionInstanceDTO;
use PHPUnit\Framework\TestCase;

class EvolutionInstanceDTOTest extends TestCase
{
    public function test_to_array_basic(): void
    {
        $dto = new EvolutionInstanceDTO(instanceName: 'test-instance');

        $array = $dto->toArray();

        $this->assertEquals('test-instance', $array['instanceName']);
        $this->assertTrue($array['qrcode']);
        $this->assertEquals('WHATSAPP-BAILEYS', $array['integration']);
        $this->assertArrayNotHasKey('token', $array);
        $this->assertArrayNotHasKey('number', $array);
    }

    public function test_to_array_with_optional_fields(): void
    {
        $dto = new EvolutionInstanceDTO(
            instanceName: 'my-instance',
            token: 'abc123',
            number: '+5511999999999',
            qrcode: false,
        );

        $array = $dto->toArray();

        $this->assertEquals('my-instance', $array['instanceName']);
        $this->assertFalse($array['qrcode']);
        $this->assertEquals('abc123', $array['token']);
        $this->assertEquals('+5511999999999', $array['number']);
    }

    public function test_to_array_with_webhook(): void
    {
        $dto = new EvolutionInstanceDTO(
            instanceName: 'webhook-instance',
            webhookUrl: 'https://mysite.com/webhook/1',
        );

        $array = $dto->toArray();

        $this->assertArrayHasKey('webhook', $array);
        $this->assertEquals('https://mysite.com/webhook/1', $array['webhook']['url']);
        $this->assertIsArray($array['webhook']['events']);
        $this->assertNotEmpty($array['webhook']['events']);
    }
}
