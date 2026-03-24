<?php

namespace App\DTOs;

class EvolutionInstanceDTO
{
    public function __construct(
        public readonly string $instanceName,
        public readonly ?string $token = null,
        public readonly ?string $number = null,
        public readonly ?string $businessId = null,
        public readonly bool $qrcode = true,
        public readonly string $integration = 'WHATSAPP-BAILEYS',
        public readonly ?string $webhookUrl = null,
        public readonly array $webhookEvents = [],
        public readonly bool $webhookByEvents = false,
        public readonly bool $webhookBase64 = false,
    ) {}

    public function toArray(): array
    {
        $data = [
            'instanceName' => $this->instanceName,
            'qrcode' => $this->qrcode,
            'integration' => $this->integration,
        ];

        if ($this->token !== null) {
            $data['token'] = $this->token;
        }

        if ($this->number !== null) {
            $data['number'] = $this->number;
        }

        if ($this->businessId !== null) {
            $data['businessId'] = $this->businessId;
        }

        if ($this->webhookUrl !== null) {
            $data['webhook'] = [
                'url' => $this->webhookUrl,
                'byEvents' => $this->webhookByEvents,
                'base64' => $this->webhookBase64,
                'events' => $this->webhookEvents ?: [
                    'APPLICATION_STARTUP',
                    'QRCODE_UPDATED',
                    'MESSAGES_SET',
                    'MESSAGES_UPSERT',
                    'MESSAGES_UPDATE',
                    'MESSAGES_DELETE',
                    'SEND_MESSAGE',
                    'CONTACTS_SET',
                    'CONTACTS_UPSERT',
                    'CONTACTS_UPDATE',
                    'PRESENCE_UPDATE',
                    'CHATS_SET',
                    'CHATS_UPSERT',
                    'CHATS_UPDATE',
                    'CHATS_DELETE',
                    'GROUPS_UPSERT',
                    'GROUPS_UPDATE',
                    'GROUP_PARTICIPANTS_UPDATE',
                    'CONNECTION_UPDATE',
                    'CALL',
                    'NEW_JWT_TOKEN',
                ],
            ];
        }

        return $data;
    }
}
