<?php

namespace App\Livewire\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ManageUsers extends Component
{
    use WithPagination;

    public function toggleStatus(User $user): void
    {
        if ($user->id === Auth::id() || $user->role === UserRole::Admin) {
            session()->flash('error', 'Admin accounts cannot be deactivated from this screen.');

            return;
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        session()->flash('success', $user->is_active ? 'User activated successfully.' : 'User deactivated successfully.');
    }

    public function render(): View
    {
        return view('livewire.admin.manage-users', [
            'users' => User::query()
                ->latest()
                ->paginate(10),
        ]);
    }
}
