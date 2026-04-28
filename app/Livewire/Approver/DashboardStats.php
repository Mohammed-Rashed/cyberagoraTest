<?php

namespace App\Livewire\Approver;

use App\Enums\ApprovalActionType;
use App\Enums\ApprovalRequestStatus;
use App\Models\ApprovalAction;
use App\Models\ApprovalRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render(): View
    {
        $actionsQuery = ApprovalAction::query()
            ->where('approver_id', Auth::id());

        return view('livewire.approver.dashboard-stats', [
            'stats' => [
                'pendingRequests' => ApprovalRequest::query()
                    ->where('status', ApprovalRequestStatus::Pending->value)
                    ->whereHas('requestSteps', function ($query): void {
                        $query
                            ->where('approver_id', Auth::id())
                            ->whereColumn('approval_request_steps.step_order', 'approval_requests.current_step_order');
                    })
                    ->count(),
                'totalActions' => (clone $actionsQuery)->count(),
                'approvedActions' => (clone $actionsQuery)
                    ->where('action', ApprovalActionType::Approved->value)
                    ->count(),
                'rejectedActions' => (clone $actionsQuery)
                    ->where('action', ApprovalActionType::Rejected->value)
                    ->count(),
                'latestActions' => (clone $actionsQuery)
                    ->with(['approvalRequest.form', 'approvalRequest.requester'])
                    ->latest('acted_at')
                    ->limit(5)
                    ->get(),
            ],
        ]);
    }
}
