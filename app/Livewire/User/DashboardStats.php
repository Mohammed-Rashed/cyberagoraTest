<?php

namespace App\Livewire\User;

use App\Enums\ApprovalRequestStatus;
use App\Models\ApprovalRequest;
use App\Models\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render(): View
    {
        $baseQuery = ApprovalRequest::query()
            ->where('requested_by', Auth::id());

        return view('livewire.user.dashboard-stats', [
            'stats' => [
                'availableForms' => Form::query()->where('is_active', true)->count(),
                'totalRequests' => (clone $baseQuery)->count(),
                'pendingRequests' => (clone $baseQuery)
                    ->where('status', ApprovalRequestStatus::Pending->value)
                    ->count(),
                'approvedRequests' => (clone $baseQuery)
                    ->where('status', ApprovalRequestStatus::Approved->value)
                    ->count(),
                'rejectedRequests' => (clone $baseQuery)
                    ->where('status', ApprovalRequestStatus::Rejected->value)
                    ->count(),
                'withdrawnRequests' => (clone $baseQuery)
                    ->where('status', ApprovalRequestStatus::Withdrawn->value)
                    ->count(),
                'latestRequests' => (clone $baseQuery)
                    ->with(['form', 'requestSteps.approver'])
                    ->latest()
                    ->limit(5)
                    ->get(),
            ],
        ]);
    }
}
