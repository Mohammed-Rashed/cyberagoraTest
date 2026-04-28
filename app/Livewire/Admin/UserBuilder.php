<?php

namespace App\Livewire\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class UserBuilder extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public int $role = 2;

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'integer', Rule::in([
                UserRole::User->value,
                UserRole::Approver->value,
            ])],
        ]);

        User::query()->create($validated);

        session()->flash('success', 'User created successfully.');

        $this->redirectRoute('admin.users.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.user-builder', [
            'roles' => [
                UserRole::User,
                UserRole::Approver,
            ],
        ]);
    }
}
