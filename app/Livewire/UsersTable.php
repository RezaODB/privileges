<?php

namespace App\Livewire;

use App\Models\Quota;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Component;

class UsersTable extends Component
{
    private const FLAG_FIELDS = [
        'important',
        'shot',
        'questionnaire',
        'interviewed',
        'eject',
    ];

    public function updateFlag(int $userId, string $field, bool $value): void
    {
        $this->authorizeAdmin();

        if (! in_array($field, self::FLAG_FIELDS, true)) {
            return;
        }

        User::query()
            ->whereKey($userId)
            ->update([$field => $value]);
    }

    #[Computed]
    public function users()
    {
        return User::query()
            ->with('answers')
            ->orderBy('eject')
            ->orderBy('order')
            ->get();
    }

    #[Computed]
    public function quotasCount(): int
    {
        return Quota::count();
    }

    #[Computed]
    public function votesCount(): int
    {
        return Vote::count();
    }

    public function render()
    {
        $this->authorizeAdmin();

        return view('livewire.users-table');
    }

    private function authorizeAdmin(): void
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
    }
}
