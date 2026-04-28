<?php

namespace App\Livewire\Admin;

use App\Enums\ApprovalRequestStatus;
use App\Enums\UserRole;
use App\Models\ApprovalAction;
use App\Models\ApprovalRequest;
use App\Models\Form;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render(): View
    {
        return view('livewire.admin.dashboard-stats', [
            'stats' => [
                'totalForms' => Form::query()->count(),
                'activeForms' => Form::query()->where('is_active', true)->count(),
                'totalUsers' => User::query()->where('role', UserRole::User->value)->count(),
                'activeUsers' => User::query()
                    ->where('role', UserRole::User->value)
                    ->where('is_active', true)
                    ->count(),
                'totalApprovers' => User::query()->where('role', UserRole::Approver->value)->count(),
                'activeApprovers' => User::query()
                    ->where('role', UserRole::Approver->value)
                    ->where('is_active', true)
                    ->count(),
                'pendingRequests' => ApprovalRequest::query()
                    ->where('status', ApprovalRequestStatus::Pending->value)
                    ->count(),
                'approvedRequests' => ApprovalRequest::query()
                    ->where('status', ApprovalRequestStatus::Approved->value)
                    ->count(),
                'rejectedRequests' => ApprovalRequest::query()
                    ->where('status', ApprovalRequestStatus::Rejected->value)
                    ->count(),
                'withdrawnRequests' => ApprovalRequest::query()
                    ->where('status', ApprovalRequestStatus::Withdrawn->value)
                    ->count(),
                'approvalActions' => ApprovalAction::query()->count(),
            ],
        ]);
    }
}
