<?php

namespace App\Services;

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
}
