<?php

namespace App\Livewire\Admin;

use App\Enums\UserRole;
use App\Models\ApprovalWorkflowStep;
use App\Models\Form;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class WorkflowBuilder extends Component
{
    public Form $form;

    /** @var array<int, array<string, mixed>> */
    public array $steps = [];

    public function mount(Form $form): void
    {
        $this->form = $form;
        $this->steps = $form->workflowSteps()
            ->get()
            ->map(fn (ApprovalWorkflowStep $step): array => [
                'id' => $step->id,
                'approver_id' => $step->approver_id,
            ])
            ->values()
            ->all();

        if ($this->steps === []) {
            $this->addStep();
        }
    }

    public function addStep(): void
    {
        $this->steps[] = [
            'id' => null,
            'approver_id' => '',
        ];
    }

    public function removeStep(int $index): void
    {
        unset($this->steps[$index]);

        $this->steps = array_values($this->steps);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'steps' => ['required', 'array', 'min:1'],
            'steps.*.id' => ['nullable', 'integer'],
            'steps.*.approver_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $this->syncSteps($validated['steps']);

        session()->flash('success', 'Workflow updated successfully.');

        $this->redirectRoute('admin.forms.index', navigate: true);
    }

    /**
     * @param  array<int, array<string, mixed>>  $steps
     */
    private function syncSteps(array $steps): void
    {
        $keptIds = [];

        foreach ($steps as $index => $step) {
            $values = [
                'approver_id' => (int) $step['approver_id'],
                'step_order' => $index + 1,
            ];

            if ($step['id']) {
                $workflowStep = $this->form->workflowSteps()->whereKey($step['id'])->first();

                if ($workflowStep) {
                    $workflowStep->update($values);
                    $keptIds[] = $workflowStep->id;

                    continue;
                }
            }

            $created = $this->form->workflowSteps()->create($values);
            $keptIds[] = $created->id;
        }

        $this->form->workflowSteps()
            ->whereNotIn('id', $keptIds)
            ->delete();
    }

    public function render(): View
    {
        return view('livewire.admin.workflow-builder', [
            'approvers' => User::query()
                ->where('role', UserRole::Approver->value)
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }
}
