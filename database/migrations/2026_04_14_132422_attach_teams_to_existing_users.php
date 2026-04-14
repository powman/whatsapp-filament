<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Attach existing users to a default team
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                if ($user->teams()->count() === 0) {
                    // Create or get first team
                    $team = Team::firstOrCreate(
                        ['slug' => 'default'],
                        ['name' => 'Default Team']
                    );
                    $user->teams()->attach($team);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Detach all team relationships
        DB::table('team_user')->truncate();
    }
};
