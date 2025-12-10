<?php

namespace Laravilt\Laravilt\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Artisan;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class MakeUserTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = 'Create a new admin user for Laravilt panel';

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        if (! $name || ! $email || ! $password) {
            return Response::text('Error: Name, email, and password are all required.');
        }

        // Validate email format
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return Response::text('Error: Invalid email format.');
        }

        // Check if user already exists
        $userModel = config('laravilt.user_model', 'App\\Models\\User');
        if (class_exists($userModel) && $userModel::where('email', $email)->exists()) {
            return Response::text("Error: A user with email '{$email}' already exists.");
        }

        try {
            Artisan::call('laravilt:make-user', [
                '--name' => $name,
                '--email' => $email,
                '--password' => $password,
            ]);

            $output = Artisan::output();

            return Response::text("Admin user created successfully.\n\n".$output);
        } catch (\Exception $e) {
            return Response::text("Failed to create user: {$e->getMessage()}");
        }
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string('Full name of the user')->required(),
            'email' => $schema->string('Email address for login')->required(),
            'password' => $schema->string('Password for the user')->required(),
        ];
    }
}
