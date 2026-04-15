<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([TenantScope::class])]
class WhatsappConnection extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'instance_name',
        'evolution_instance_id',
        'api_key',
        'phone_number',
        'profile_name',
        'profile_pic_url',
        'status',
        'settings',
        'error_message',
        'last_sync_at',
        'connected_at',
    ];

    protected $casts = [
        'settings' => 'json',
        'created_at' => 'datetime',
        'last_sync_at' => 'datetime',
        'connected_at' => 'datetime',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function isConnected(): bool
    {
        return $this->status === 'connected';
    }

    public function isDisconnected(): bool
    {
        return $this->status === 'disconnected';
    }

    public function isConnecting(): bool
    {
        return $this->status === 'connecting';
    }

    public function hasError(): bool
    {
        return $this->status === 'error';
    }
}
