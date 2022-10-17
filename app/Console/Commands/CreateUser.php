<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Throwable;

class CreateUser extends Command
{
    private const PASSWORD_MIN_LENGTH = 8;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for create user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email is invalid');

            return SymfonyCommand::FAILURE;
        }

        if (mb_strlen($password) < self::PASSWORD_MIN_LENGTH) {
            $this->error(sprintf('Password must contain at least %u characters', self::PASSWORD_MIN_LENGTH));

            return SymfonyCommand::FAILURE;
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
        } catch (Throwable $e) {
            $this->error(sprintf('Undefined exception: %s', $e->getMessage()));

            return SymfonyCommand::FAILURE;
        }

        $this->info(sprintf('User `%s` with email `%s` successfully created', $user->name, $user->email));

        return SymfonyCommand::SUCCESS;
    }
}
