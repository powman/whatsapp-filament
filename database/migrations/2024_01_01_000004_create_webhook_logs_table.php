<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('whatsapp_instance_id')->nullable()->constrained()->onDelete('set null');
            $table->string('event');
            $table->json('payload');
            $table->enum('status', ['pending', 'processed', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'event']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
    }
};
