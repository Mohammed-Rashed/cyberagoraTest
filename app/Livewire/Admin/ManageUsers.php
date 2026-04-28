<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ManageUsers extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.admin.manage-users', [
            'users' => User::query()
                ->latest()
                ->paginate(10),
        ]);
    }
}
