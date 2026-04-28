<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->foreign('created_by', 'forms_created_by_fk')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();
        });

        Schema::table('form_fields', function (Blueprint $table) {
            $table->foreign('form_id', 'form_fields_form_id_fk')
                ->references('id')
                ->on('forms')
                ->cascadeOnDelete();
        });

        Schema::table('approval_workflow_steps', function (Blueprint $table) {
            $table->unique(['form_id', 'step_order'], 'workflow_steps_form_order_unique');

            $table->foreign('form_id', 'workflow_steps_form_id_fk')
                ->references('id')
                ->on('forms')
                ->cascadeOnDelete();

            $table->foreign('approver_id', 'workflow_steps_approver_id_fk')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();
        });

        Schema::table('approval_requests', function (Blueprint $table) {
            $table->foreign('form_id', 'approval_requests_form_id_fk')
                ->references('id')
                ->on('forms')
                ->restrictOnDelete();

            $table->foreign('requested_by', 'approval_requests_requested_by_fk')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();
        });

        Schema::table('approval_request_values', function (Blueprint $table) {
            $table->unique(
                ['approval_request_id', 'form_field_id'],
                'request_values_request_field_unique'
            );

            $table->foreign('approval_request_id', 'request_values_request_id_fk')
                ->references('id')
                ->on('approval_requests')
                ->cascadeOnDelete();

            $table->foreign('form_field_id', 'request_values_form_field_id_fk')
                ->references('id')
                ->on('form_fields')
                ->restrictOnDelete();
        });

        Schema::table('approval_actions', function (Blueprint $table) {
            $table->unique(
                ['approval_request_id', 'approval_workflow_step_id'],
                'approval_actions_request_step_unique'
            );

            $table->foreign('approval_request_id', 'approval_actions_request_id_fk')
                ->references('id')
                ->on('approval_requests')
                ->cascadeOnDelete();

            $table->foreign('approval_workflow_step_id', 'approval_actions_workflow_step_id_fk')
                ->references('id')
                ->on('approval_workflow_steps')
                ->restrictOnDelete();

            $table->foreign('approver_id', 'approval_actions_approver_id_fk')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();
        });

        Schema::table('approval_request_steps', function (Blueprint $table) {
            $table->unique(
                ['approval_request_id', 'step_order'],
                'request_steps_request_order_unique'
            );

            $table->foreign('approval_request_id', 'request_steps_request_id_fk')
                ->references('id')
                ->on('approval_requests')
                ->cascadeOnDelete();

            $table->foreign('approver_id', 'request_steps_approver_id_fk')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('approval_request_steps', function (Blueprint $table) {
            $table->dropForeign('request_steps_request_id_fk');
            $table->dropForeign('request_steps_approver_id_fk');
            $table->dropUnique('request_steps_request_order_unique');
        });

        Schema::table('approval_actions', function (Blueprint $table) {
            $table->dropForeign('approval_actions_request_id_fk');
            $table->dropForeign('approval_actions_workflow_step_id_fk');
            $table->dropForeign('approval_actions_approver_id_fk');
            $table->dropUnique('approval_actions_request_step_unique');
        });

        Schema::table('approval_request_values', function (Blueprint $table) {
            $table->dropForeign('request_values_request_id_fk');
            $table->dropForeign('request_values_form_field_id_fk');
            $table->dropUnique('request_values_request_field_unique');
        });

        Schema::table('approval_requests', function (Blueprint $table) {
            $table->dropForeign('approval_requests_form_id_fk');
            $table->dropForeign('approval_requests_requested_by_fk');
        });

        Schema::table('approval_workflow_steps', function (Blueprint $table) {
            $table->dropForeign('workflow_steps_form_id_fk');
            $table->dropForeign('workflow_steps_approver_id_fk');
            $table->dropUnique('workflow_steps_form_order_unique');
        });

        Schema::table('form_fields', function (Blueprint $table) {
            $table->dropForeign('form_fields_form_id_fk');
        });

        Schema::table('forms', function (Blueprint $table) {
            $table->dropForeign('forms_created_by_fk');
        });
    }
};
