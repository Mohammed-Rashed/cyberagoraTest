<?php

namespace App\Services;

use App\Enums\ApprovalActionType;
use App\Enums\ApprovalRequestStatus;
use App\Models\ApprovalRequest;
use App\Models\Form;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApprovalRequestService
{
    /**
     * @param  array<int, mixed>  $values
     */
    public function submit(Form $form, User $user, array $values): ApprovalRequest
    {
        if (! $form->is_active) {
            throw ValidationException::withMessages([
                'form' => 'This form is not active.',
            ]);
        }

        if (! $form->workflowSteps()->exists()) {
            throw ValidationException::withMessages([
                'form' => 'This form does not have an approval workflow yet.',
            ]);
        }

        $fieldIds = $form->fields()->pluck('id')->all();
        $submittedFieldIds = array_map('intval', array_keys($values));

        if (array_diff($submittedFieldIds, $fieldIds) !== []) {
            throw ValidationException::withMessages([
                'form' => 'Invalid submitted fields.',
            ]);
        }

        return DB::transaction(function () use ($form, $user, $values): ApprovalRequest {
            $approvalRequest = ApprovalRequest::query()->create([
                'form_id' => $form->id,
                'requested_by' => $user->id,
                'status' => ApprovalRequestStatus::Pending,
                'current_step_order' => $form->workflowSteps()->min('step_order') ?? 1,
                'submitted_at' => now(),
            ]);

            foreach ($form->fields as $field) {
                $approvalRequest->values()->create([
                    'form_field_id' => $field->id,
                    'value' => $values[$field->id] ?? null,
                ]);
            }

            return $approvalRequest;
        });
    }

    public function approve(ApprovalRequest $approvalRequest, User $approver, ?string $comment = null): ApprovalRequest
    {
        return $this->act($approvalRequest, $approver, ApprovalActionType::Approved, $comment);
    }

    public function reject(ApprovalRequest $approvalRequest, User $approver, ?string $comment = null): ApprovalRequest
    {
        return $this->act($approvalRequest, $approver, ApprovalActionType::Rejected, $comment);
    }

    private function act(
        ApprovalRequest $approvalRequest,
        User $approver,
        ApprovalActionType $action,
        ?string $comment = null,
    ): ApprovalRequest {
        return DB::transaction(function () use ($approvalRequest, $approver, $action, $comment): ApprovalRequest {
            $approvalRequest = ApprovalRequest::query()
                ->with('form.workflowSteps')
                ->lockForUpdate()
                ->findOrFail($approvalRequest->id);

            if ($approvalRequest->status !== ApprovalRequestStatus::Pending) {
                throw ValidationException::withMessages([
                    'approval' => 'This request is no longer pending.',
                ]);
            }

            $currentStep = $approvalRequest->form
                ->workflowSteps()
                ->where('step_order', $approvalRequest->current_step_order)
                ->where('approver_id', $approver->id)
                ->first();

            if (! $currentStep) {
                throw ValidationException::withMessages([
                    'approval' => 'You are not assigned to the current approval step.',
                ]);
            }

            $approvalRequest->actions()->create([
                'approval_workflow_step_id' => $currentStep->id,
                'approver_id' => $approver->id,
                'action' => $action,
                'comment' => $comment,
                'acted_at' => now(),
            ]);

            if ($action === ApprovalActionType::Rejected) {
                $approvalRequest->update([
                    'status' => ApprovalRequestStatus::Rejected,
                ]);

                return $approvalRequest->refresh();
            }

            $nextStepOrder = $approvalRequest->form
                ->workflowSteps()
                ->where('step_order', '>', $approvalRequest->current_step_order)
                ->min('step_order');

            if ($nextStepOrder) {
                $approvalRequest->update([
                    'current_step_order' => $nextStepOrder,
                ]);
            } else {
                $approvalRequest->update([
                    'status' => ApprovalRequestStatus::Approved,
                ]);
            }

            return $approvalRequest->refresh();
        });
    }
}
