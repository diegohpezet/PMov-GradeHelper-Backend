<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ToggleAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:toggle-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");
            return;
        }

        if ($user->hasRole('admin')) {
            $user->removeRole('admin');
            $this->info("User {$email} is no longer an admin.");
            return;
        }

        $user->assignRole('admin');
        $this->info("User {$email} has been assigned the admin role.");
    }
}
