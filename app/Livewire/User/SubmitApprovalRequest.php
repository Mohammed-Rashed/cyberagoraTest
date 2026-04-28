<?php

namespace App\Livewire\User;

use App\Enums\FormFieldType;
use App\Models\Form;
use App\Models\FormField;
use App\Services\ApprovalRequestService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class SubmitApprovalRequest extends Component
{
    public Form $form;

    /** @var array<int, mixed> */
    public array $values = [];

    public function mount(Form $form): void
    {
        abort_unless($form->is_active, 404);

        $this->form = $form->load(['fields', 'workflowSteps']);

        foreach ($this->form->fields as $field) {
            $this->values[$field->id] = '';
        }
    }

    public function submit(ApprovalRequestService $approvalRequestService): void
    {
        $this->validate($this->rules());

        $approvalRequestService->submit($this->form, Auth::user(), $this->values);

        session()->flash('success', 'Approval request submitted successfully.');

        $this->redirectRoute('forms.index', navigate: true);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        $rules = [];

        foreach ($this->form->fields as $field) {
            $fieldRules = [$field->is_required ? 'required' : 'nullable'];

            $fieldRules = [
                ...$fieldRules,
                ...$this->rulesForFieldType($field),
            ];

            $rules['values.'.$field->id] = $fieldRules;
        }

        return $rules;
    }

    /**
     * @return array<int, mixed>
     */
    private function rulesForFieldType(FormField $field): array
    {
        return match ($field->type) {
            FormFieldType::Number => ['numeric'],
            FormFieldType::Date => ['date'],
            FormFieldType::Select => [Rule::in($field->options ?? [])],
            default => ['string', 'max:5000'],
        };
    }

    public function render(): View
    {
        return view('livewire.user.submit-approval-request');
    }
}
