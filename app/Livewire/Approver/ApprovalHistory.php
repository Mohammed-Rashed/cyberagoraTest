<?php

namespace App\Livewire\Approver;

use App\Models\ApprovalAction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ApprovalHistory extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.approver.approval-history', [
            'actions' => ApprovalAction::query()
                ->with(['approvalRequest.form', 'approvalRequest.requester'])
                ->where('approver_id', Auth::id())
                ->latest('acted_at')
                ->paginate(10),
        ]);
    }
}
