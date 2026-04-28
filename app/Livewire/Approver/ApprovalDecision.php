<?php

namespace App\Livewire\Approver;

use App\Models\ApprovalRequest;
use App\Services\ApprovalRequestService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ApprovalDecision extends Component
{
    public ApprovalRequest $approvalRequest;

    public ?string $comment = null;

    public function mount(ApprovalRequest $approvalRequest): void
    {
        $this->approvalRequest = $approvalRequest->load([
            'form.fields',
            'requester',
            'values.formField',
        ]);

        abort_unless($this->canActOnRequest(), 403);
    }

    public function approve(ApprovalRequestService $approvalRequestService): void
    {
        $this->validateDecision();

        $approvalRequestService->approve($this->approvalRequest, Auth::user(), $this->comment);

        session()->flash('success', 'Request approved successfully.');

        $this->redirectRoute('approvals.pending', navigate: true);
    }

    public function reject(ApprovalRequestService $approvalRequestService): void
    {
        $this->validateDecision();

        $approvalRequestService->reject($this->approvalRequest, Auth::user(), $this->comment);

        session()->flash('success', 'Request rejected successfully.');

        $this->redirectRoute('approvals.pending', navigate: true);
    }

    private function validateDecision(): void
    {
        $this->validate([
            'comment' => ['nullable', 'string', 'max:5000'],
        ]);
    }

    private function canActOnRequest(): bool
    {
        return $this->approvalRequest
            ->requestSteps()
            ->where('step_order', $this->approvalRequest->current_step_order)
            ->where('approver_id', Auth::id())
            ->exists();
    }

    public function render(): View
    {
        return view('livewire.approver.approval-decision');
    }
}
