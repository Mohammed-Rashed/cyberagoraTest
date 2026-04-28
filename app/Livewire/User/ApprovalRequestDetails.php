<?php

namespace App\Livewire\User;

use App\Models\ApprovalRequest;
use App\Services\ApprovalRequestService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ApprovalRequestDetails extends Component
{
    public ApprovalRequest $approvalRequest;

    public function mount(ApprovalRequest $approvalRequest): void
    {
        abort_unless($approvalRequest->requested_by === Auth::id(), 403);

        $this->loadApprovalRequest($approvalRequest);
    }

    public function withdraw(ApprovalRequestService $approvalRequestService): void
    {
        $approvalRequestService->withdraw($this->approvalRequest, Auth::user());

        session()->flash('success', 'Approval request withdrawn successfully.');

        $this->redirectRoute('my-requests.show', [
            'approvalRequest' => $this->approvalRequest->id,
        ], navigate: true);
    }

    private function loadApprovalRequest(ApprovalRequest $approvalRequest): void
    {
        $this->approvalRequest = $approvalRequest->load([
            'form',
            'requestSteps.approver',
            'values.formField',
            'actions.approver',
            'actions.workflowStep',
        ]);
    }

    public function render(): View
    {
        return view('livewire.user.approval-request-details');
    }
}
