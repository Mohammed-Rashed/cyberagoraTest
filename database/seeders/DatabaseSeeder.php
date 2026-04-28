<?php

namespace Database\Seeders;

use App\Enums\FormFieldType;
use App\Enums\UserRole;
use App\Models\ApprovalWorkflowStep;
use App\Models\Form;
use App\Models\FormField;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'email_verified_at' => now(),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'password' => Hash::make('password'),
                'role' => UserRole::User,
                'email_verified_at' => now(),
            ],
        );

        $approver = User::query()->updateOrCreate(
            ['email' => 'approver@example.com'],
            [
                'name' => 'First Approver',
                'password' => Hash::make('password'),
                'role' => UserRole::Approver,
                'email_verified_at' => now(),
            ],
        );

        $approver2 = User::query()->updateOrCreate(
            ['email' => 'approver2@example.com'],
            [
                'name' => 'Second Approver',
                'password' => Hash::make('password'),
                'role' => UserRole::Approver,
                'email_verified_at' => now(),
            ],
        );

        $form = Form::query()->updateOrCreate(
            ['name' => 'Leave Request'],
            [
                'description' => 'Request approval for employee leave.',
                'is_active' => true,
                'created_by' => $admin->id,
            ],
        );

        $fields = [
            [
                'label' => 'Employee Name',
                'name' => 'employee_name',
                'type' => FormFieldType::Text,
                'is_required' => true,
                'sort_order' => 1,
            ],
            [
                'label' => 'Leave Date',
                'name' => 'leave_date',
                'type' => FormFieldType::Date,
                'is_required' => true,
                'sort_order' => 2,
            ],
            [
                'label' => 'Reason',
                'name' => 'reason',
                'type' => FormFieldType::Textarea,
                'is_required' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($fields as $field) {
            FormField::query()->updateOrCreate(
                [
                    'form_id' => $form->id,
                    'name' => $field['name'],
                ],
                [
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'is_required' => $field['is_required'],
                    'options' => null,
                    'sort_order' => $field['sort_order'],
                ],
            );
        }

        ApprovalWorkflowStep::query()->updateOrCreate(
            [
                'form_id' => $form->id,
                'step_order' => 1,
            ],
            ['approver_id' => $approver->id],
        );

        ApprovalWorkflowStep::query()->updateOrCreate(
            [
                'form_id' => $form->id,
                'step_order' => 2,
            ],
            ['approver_id' => $approver2->id],
        );
    }
}
