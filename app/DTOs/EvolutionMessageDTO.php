<?php

namespace App\DTOs;

class EvolutionMessageDTO
{
    public function __construct(
        public readonly string $number,
        public readonly string $text,
        public readonly ?string $delay = null,
        public readonly bool $quoted = false,
        public readonly bool $mentions = false,
    ) {}

    public function toArray(): array
    {
        $data = [
            'number' => $this->number,
            'text' => $this->text,
        ];

        if ($this->delay !== null) {
            $data['delay'] = $this->delay;
        }

        return $data;
    }
}
