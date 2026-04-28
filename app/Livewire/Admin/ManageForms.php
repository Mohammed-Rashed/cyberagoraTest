<?php

namespace App\Livewire\Admin;

use App\Models\Form;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ManageForms extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.admin.manage-forms', [
            'forms' => Form::query()
                ->withCount(['fields', 'workflowSteps'])
                ->latest()
                ->paginate(10),
        ]);
    }
}
