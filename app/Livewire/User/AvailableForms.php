<?php

namespace App\Livewire\User;

use App\Models\Form;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class AvailableForms extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.user.available-forms', [
            'forms' => Form::query()
                ->where('is_active', true)
                ->withCount(['fields', 'workflowSteps'])
                ->latest()
                ->paginate(10),
        ]);
    }
}
