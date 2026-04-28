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
    public ?Form $form = null;

    public string $name = '';

    public ?string $description = null;

    public bool $is_active = true;

    public function mount(?Form $form = null): void
    {
        if (! $form?->exists) {
            return;
        }

        $this->form = $form;
        $this->name = $form->name;
        $this->description = $form->description;
        $this->is_active = $form->is_active;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['boolean'],
        ]);

        if ($this->form) {
            $this->form->update($validated);
            session()->flash('success', 'Form updated successfully.');
        } else {
            Form::query()->create([
                ...$validated,
                'created_by' => Auth::id(),
            ]);

            session()->flash('success', 'Form created successfully.');
        }

        $this->redirectRoute('admin.forms.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.form-builder');
    }
}
