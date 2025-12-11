<?php

namespace Laravilt\Laravilt\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'laravilt:user
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

        $this->newLine();
        $this->components->info('👤 Create Admin User');
        $this->newLine();

        // Get name using Laravel Prompts
        $name = $this->option('name') ?? text(
            label: 'What is the user\'s name?',
            placeholder: 'John Doe',
            required: true,
            validate: fn (string $value) => match (true) {
                strlen($value) < 2 => 'Name must be at least 2 characters.',
                default => null
            }
        );

        // Get email using Laravel Prompts
        $email = $this->option('email') ?? text(
            label: 'What is the user\'s email?',
            placeholder: 'admin@example.com',
            required: true,
            validate: fn (string $value) => match (true) {
                ! filter_var($value, FILTER_VALIDATE_EMAIL) => 'Please enter a valid email address.',
                $userModel::where('email', $value)->exists() => 'A user with this email already exists.',
                default => null
            }
        );

        // Check if user already exists (for --email option)
        if ($this->option('email') && $userModel::where('email', $email)->exists()) {
            $this->components->error("A user with email [{$email}] already exists.");

            return self::FAILURE;
        }

        // Get password using Laravel Prompts
        $userPassword = $this->option('password') ?? password(
            label: 'What is the user\'s password?',
            placeholder: 'Enter a secure password',
            required: true,
            validate: fn (string $value) => match (true) {
                strlen($value) < 8 => 'Password must be at least 8 characters.',
                default => null
            },
            hint: 'Minimum 8 characters'
        );

        // Confirm password
        if (! $this->option('password')) {
            $confirmPassword = password(
                label: 'Confirm the password',
                required: true,
                validate: fn (string $value) => match (true) {
                    $value !== $userPassword => 'Passwords do not match.',
                    default => null
                }
            );
        }

        // Create the user
        $user = $userModel::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($userPassword),
            'email_verified_at' => now(),
        ]);

        $this->newLine();
        $this->components->info("✅ User [{$user->name}] created successfully!");
        $this->newLine();

        $this->components->bulletList([
            "Name: <fg=cyan>{$user->name}</>",
            "Email: <fg=cyan>{$user->email}</>",
            'Login at: <fg=yellow>/admin/login</>',
        ]);

        $this->newLine();

        return self::SUCCESS;
    }
}
