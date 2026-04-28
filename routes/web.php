<?php

use App\Livewire\Admin\FormBuilder;
use App\Livewire\Admin\ManageForms;
use App\Livewire\Admin\WorkflowBuilder;
use App\Livewire\Approver\PendingApprovals;
use App\Livewire\User\AvailableForms;
use App\Livewire\User\MyApprovalRequests;
use App\Livewire\User\SubmitApprovalRequest;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('forms', AvailableForms::class)->name('forms.index');
    Route::get('forms/{form}/submit', SubmitApprovalRequest::class)->name('forms.submit');
    Route::get('my-requests', MyApprovalRequests::class)->name('my-requests.index');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('forms/create', FormBuilder::class)->name('forms.create');
        Route::get('forms/{form}/edit', FormBuilder::class)->name('forms.edit');
        Route::get('forms/{form}/workflow', WorkflowBuilder::class)->name('forms.workflow');
        Route::get('forms', ManageForms::class)->name('forms.index');
    });

Route::middleware(['auth', 'role:approver'])
    ->prefix('approvals')
    ->name('approvals.')
    ->group(function () {
        Route::get('pending', PendingApprovals::class)->name('pending');
    });

require __DIR__.'/auth.php';
