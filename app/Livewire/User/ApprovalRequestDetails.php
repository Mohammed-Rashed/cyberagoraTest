<?php

namespace App\Livewire\User;

use App\Models\ApprovalRequest;
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

        $this->approvalRequest = $approvalRequest->load([
            'form.workflowSteps.approver',
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
