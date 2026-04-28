<?php

namespace App\Livewire\Approver;

use App\Enums\ApprovalRequestStatus;
use App\Models\ApprovalRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class PendingApprovals extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.approver.pending-approvals', [
            'approvalRequests' => ApprovalRequest::query()
                ->with(['form', 'requester'])
                ->where('status', ApprovalRequestStatus::Pending->value)
                ->whereHas('form.workflowSteps', function ($query): void {
                    $query
                        ->where('approver_id', Auth::id())
                        ->whereColumn('approval_workflow_steps.step_order', 'approval_requests.current_step_order');
                })
                ->latest()
                ->paginate(10),
        ]);
    }
}
