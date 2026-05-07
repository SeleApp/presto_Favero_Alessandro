<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserRevisor extends Command
{
    protected $signature = 'app:make-user-revisor {email}';

    protected $description = 'Promote an existing user to revisor';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('Utente non trovato.');

            return self::FAILURE;
        }

        $user->is_revisor = true;
        $user->save();

        $this->info("{$user->email} e' ora un revisore.");

        return self::SUCCESS;
    }
}
