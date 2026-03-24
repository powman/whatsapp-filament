<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class WhatsappInstance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'name',
        'instance_name',
        'phone_number',
        'status',
        'qr_code',
        'webhook_events',
        'webhook_url',
        'is_active',
        'connected_at',
        'last_status_at',
    ];

    protected $casts = [
        'webhook_events' => 'array',
        'is_active' => 'boolean',
        'connected_at' => 'datetime',
        'last_status_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function webhookLogs(): HasMany
    {
        return $this->hasMany(WebhookLog::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'connected' => 'success',
            'disconnected' => 'danger',
            'qr_code' => 'warning',
            'connecting' => 'info',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'connected' => 'Conectado',
            'disconnected' => 'Desconectado',
            'qr_code' => 'Aguardando QR Code',
            'connecting' => 'Conectando...',
            default => 'Desconhecido',
        };
    }

    public function isConnected(): bool
    {
        return $this->status === 'connected';
    }

    public function getCachedStatus(): string
    {
        $cacheKey = "instance_status_{$this->id}";

        return Cache::remember($cacheKey, now()->addMinutes(1), fn () => $this->status);
    }

    public function updateStatus(string $status): void
    {
        $this->update([
            'status' => $status,
            'last_status_at' => now(),
            'connected_at' => $status === 'connected' ? now() : $this->connected_at,
        ]);

        Cache::put("instance_status_{$this->id}", $status, now()->addMinutes(5));
    }
}
