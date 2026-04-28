<?php

namespace App\Livewire\Admin;

use App\Enums\FormFieldType;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class FormBuilder extends Component
{
    public ?Form $form = null;

    public string $name = '';

    public ?string $description = null;

    public bool $is_active = true;

    /** @var array<int, array<string, mixed>> */
    public array $fields = [];

    public function mount(?Form $form = null): void
    {
        if (! $form?->exists) {
            $this->addField();

            return;
        }

        $this->form = $form;
        $this->name = $form->name;
        $this->description = $form->description;
        $this->is_active = $form->is_active;
        $this->fields = $form->fields()
            ->get()
            ->map(fn (FormField $field): array => [
                'id' => $field->id,
                'label' => $field->label,
                'name' => $field->name,
                'type' => $field->type->value,
                'is_required' => $field->is_required,
                'options' => implode(', ', $field->options ?? []),
            ])
            ->values()
            ->all();

        if ($this->fields === []) {
            $this->addField();
        }
    }

    public function addField(): void
    {
        $this->fields[] = [
            'id' => null,
            'label' => '',
            'name' => '',
            'type' => FormFieldType::Text->value,
            'is_required' => false,
            'options' => '',
        ];
    }

    public function removeField(int $index): void
    {
        unset($this->fields[$index]);

        $this->fields = array_values($this->fields);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['boolean'],
            'fields' => ['required', 'array', 'min:1'],
            'fields.*.id' => ['nullable', 'integer'],
            'fields.*.label' => ['required', 'string', 'max:255'],
            'fields.*.name' => ['nullable', 'string', 'max:255'],
            'fields.*.type' => ['required', 'integer', 'in:1,2,3,4,5'],
            'fields.*.is_required' => ['boolean'],
            'fields.*.options' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($this->form) {
            $this->form->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'is_active' => $validated['is_active'],
            ]);

            $form = $this->form;
            session()->flash('success', 'Form updated successfully.');
        } else {
            $form = Form::query()->create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'is_active' => $validated['is_active'],
                'created_by' => Auth::id(),
            ]);

            session()->flash('success', 'Form created successfully.');
        }

        $this->syncFields($form, $validated['fields']);

        $this->redirectRoute('admin.forms.index', navigate: true);
    }

    /**
     * @param  array<int, array<string, mixed>>  $fields
     */
    private function syncFields(Form $form, array $fields): void
    {
        $keptIds = [];

        foreach ($fields as $index => $field) {
            $name = filled($field['name'])
                ? Str::slug($field['name'], '_')
                : Str::slug($field['label'], '_');

            $values = [
                'label' => $field['label'],
                'name' => $name,
                'type' => (int) $field['type'],
                'is_required' => (bool) $field['is_required'],
                'options' => $this->formatOptions($field),
                'sort_order' => $index + 1,
            ];

            if ($field['id']) {
                $formField = $form->fields()->whereKey($field['id'])->first();

                if ($formField) {
                    $formField->update($values);
                    $keptIds[] = $formField->id;

                    continue;
                }
            }

            $created = $form->fields()->create($values);
            $keptIds[] = $created->id;
        }

        $form->fields()
            ->whereNotIn('id', $keptIds)
            ->delete();
    }

    /**
     * @param  array<string, mixed>  $field
     * @return array<int, string>|null
     */
    private function formatOptions(array $field): ?array
    {
        if ((int) $field['type'] !== FormFieldType::Select->value) {
            return null;
        }

        return collect(explode(',', (string) $field['options']))
            ->map(fn (string $option): string => trim($option))
            ->filter()
            ->values()
            ->all();
    }

    public function render(): View
    {
        return view('livewire.admin.form-builder', [
            'fieldTypes' => FormFieldType::cases(),
        ]);
    }
}
