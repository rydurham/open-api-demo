<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

#[Signature('api:test-token {--email=} {--password=} {--device=cli-test} {--force}')]
#[Description('Issue a Sanctum personal access token for API testing (prints token only; defaults: test@example.com / password)')]
class IssueTestApiTokenCommand extends Command
{
    public function handle(): int
    {
        if (app()->isProduction() && ! $this->option('force')) {
            $this->components->error('Refused in production. Pass --force if you really intend to run this.');

            return self::FAILURE;
        }

        $email = $this->option('email') ?: 'test@example.com';
        $password = $this->option('password') ?: 'password';

        if (! Auth::attempt(['email' => $email, 'password' => $password])) {
            $this->components->error('Invalid credentials.');

            return self::FAILURE;
        }

        $user = Auth::user();
        if (! $user instanceof User) {
            $this->components->error('Invalid credentials.');

            return self::FAILURE;
        }

        $device = (string) $this->option('device');
        $plainTextToken = $user->createToken($device)->plainTextToken;

        $this->line($plainTextToken);

        return self::SUCCESS;
    }
}
