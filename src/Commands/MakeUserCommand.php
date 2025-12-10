<?php

namespace Laravilt\Laravilt\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'laravilt:make-user
                            {--name= : The name of the user}
                            {--email= : The email of the user}
                            {--password= : The password for the user}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new admin user for Laravilt';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $userModel = config('laravilt.user_model', 'App\\Models\\User');

        if (! class_exists($userModel)) {
            $this->components->error("User model [{$userModel}] not found.");
            return self::FAILURE;
        }

        $name = $this->option('name') ?? $this->ask('What is the user\'s name?');
        $email = $this->option('email') ?? $this->ask('What is the user\'s email?');
        $password = $this->option('password') ?? $this->secret('What is the user\'s password?');

        if (! $name || ! $email || ! $password) {
            $this->components->error('Name, email, and password are required.');
            return self::FAILURE;
        }

        // Check if user already exists
        if ($userModel::where('email', $email)->exists()) {
            $this->components->error("A user with email [{$email}] already exists.");
            return self::FAILURE;
        }

        // Create the user
        $user = $userModel::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->newLine();
        $this->components->info("✅ User [{$user->name}] created successfully!");
        $this->components->bulletList([
            "Email: {$user->email}",
            'Login at: /admin/login',
        ]);
        $this->newLine();

        return self::SUCCESS;
    }
}
