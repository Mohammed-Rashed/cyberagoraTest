<?php

namespace App\Livewire\Admin;

use App\Models\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class FormBuilder extends Component
{
    public string $name = '';

    public ?string $description = null;

    public bool $is_active = true;

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['boolean'],
        ]);

        Form::query()->create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        session()->flash('success', 'Form created successfully.');

        $this->redirectRoute('admin.forms.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.form-builder');
    }
}
