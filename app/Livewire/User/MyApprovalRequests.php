<?php

namespace App\Livewire\User;

use App\Models\ApprovalRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class MyApprovalRequests extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.user.my-approval-requests', [
            'approvalRequests' => ApprovalRequest::query()
                ->with(['form.workflowSteps.approver'])
                ->where('requested_by', Auth::id())
                ->latest()
                ->paginate(10),
        ]);
    }
}
