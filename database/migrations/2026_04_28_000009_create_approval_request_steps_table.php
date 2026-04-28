<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_request_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('approval_request_id');
            $table->unsignedBigInteger('approval_workflow_step_id');
            $table->unsignedBigInteger('approver_id');
            $table->unsignedInteger('step_order');
            $table->timestamps();
        });

        DB::table('approval_requests')
            ->orderBy('id')
            ->get()
            ->each(function (object $approvalRequest): void {
                DB::table('approval_workflow_steps')
                    ->where('form_id', $approvalRequest->form_id)
                    ->orderBy('step_order')
                    ->get()
                    ->each(function (object $workflowStep) use ($approvalRequest): void {
                        DB::table('approval_request_steps')->insert([
                            'approval_request_id' => $approvalRequest->id,
                            'approval_workflow_step_id' => $workflowStep->id,
                            'approver_id' => $workflowStep->approver_id,
                            'step_order' => $workflowStep->step_order,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    });
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_request_steps');
    }
};
