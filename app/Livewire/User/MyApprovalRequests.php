<?php

namespace App\Livewire\User;

use App\Models\ApprovalRequest;
use App\Services\ApprovalRequestService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class MyApprovalRequests extends Component
{
    use WithPagination;

    public function withdraw(int $approvalRequestId, ApprovalRequestService $approvalRequestService): void
    {
        $approvalRequest = ApprovalRequest::query()
            ->where('requested_by', Auth::id())
            ->findOrFail($approvalRequestId);

        $approvalRequestService->withdraw($approvalRequest, Auth::user());

        session()->flash('success', 'Approval request withdrawn successfully.');
    }

    public function render(): View
    {
        return view('livewire.user.my-approval-requests', [
            'approvalRequests' => ApprovalRequest::query()
                ->with(['form', 'requestSteps.approver'])
                ->where('requested_by', Auth::id())
                ->latest()
                ->paginate(10),
        ]);
    }
}
