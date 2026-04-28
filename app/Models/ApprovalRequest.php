<?php

namespace App\Models;

use App\Enums\ApprovalRequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApprovalRequest extends Model
{
    protected $fillable = [
        'form_id',
        'requested_by',
        'status',
        'current_step_order',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ApprovalRequestStatus::class,
            'submitted_at' => 'datetime',
        ];
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function values(): HasMany
    {
        return $this->hasMany(ApprovalRequestValue::class);
    }

    public function actions(): HasMany
    {
        return $this->hasMany(ApprovalAction::class);
    }

    public function currentWorkflowStep(): ?ApprovalWorkflowStep
    {
        return $this->form
            ?->workflowSteps()
            ->where('step_order', $this->current_step_order)
            ->first();
    }

    public function isPending(): bool
    {
        return $this->status === ApprovalRequestStatus::Pending;
    }
}
