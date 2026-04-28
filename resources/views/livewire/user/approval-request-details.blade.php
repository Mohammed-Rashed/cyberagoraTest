<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request Details') }} #{{ $approvalRequest->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @error('withdraw')
                        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <div class="text-sm font-medium text-gray-500">{{ __('Form') }}</div>
                            <div class="mt-1 text-sm text-gray-900">{{ $approvalRequest->form?->name ?? __('Deleted form') }}</div>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-500">{{ __('Status') }}</div>
                            <div class="mt-1 text-sm">
                                <span @class([
                                    'font-medium',
                                    'text-yellow-700' => $approvalRequest->status === \App\Enums\ApprovalRequestStatus::Pending,
                                    'text-green-700' => $approvalRequest->status === \App\Enums\ApprovalRequestStatus::Approved,
                                    'text-red-700' => $approvalRequest->status === \App\Enums\ApprovalRequestStatus::Rejected,
                                    'text-gray-700' => $approvalRequest->status === \App\Enums\ApprovalRequestStatus::Withdrawn,
                                ])>
                                    {{ $approvalRequest->status->name }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-500">{{ __('Current Approver') }}</div>
                            <div class="mt-1 text-sm text-gray-900">
                                @php
                                    $currentStep = $approvalRequest->status === \App\Enums\ApprovalRequestStatus::Pending
                                        ? $approvalRequest->currentRequestStep()
                                        : null;
                                @endphp

                                @if ($currentStep)
                                    {{ $currentStep->approver?->name ?? __('Deleted approver') }}
                                    @if ($currentStep->approver?->email)
                                        <div class="text-xs text-gray-500">{{ $currentStep->approver->email }}</div>
                                    @endif
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-500">{{ __('Submitted') }}</div>
                            <div class="mt-1 text-sm text-gray-900">{{ $approvalRequest->submitted_at?->format('Y-m-d H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Submitted Values') }}</h3>

                    <div class="mt-4 divide-y divide-gray-200">
                        @foreach ($approvalRequest->values as $value)
                            <div class="py-3">
                                <div class="text-sm font-medium text-gray-700">
                                    {{ $value->formField?->label ?? __('Deleted field') }}
                                </div>
                                <div class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                    {{ filled($value->value) ? $value->value : '-' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Workflow Progress') }}</h3>

                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Step</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Approver</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comment</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($approvalRequest->requestSteps as $step)
                                    @php
                                        $action = $approvalRequest->actions->firstWhere('approval_workflow_step_id', $step->approval_workflow_step_id);
                                        $isCurrent = $approvalRequest->status === \App\Enums\ApprovalRequestStatus::Pending
                                            && $approvalRequest->current_step_order === $step->step_order;
                                        $isWithdrawnStep = $approvalRequest->status === \App\Enums\ApprovalRequestStatus::Withdrawn
                                            && $approvalRequest->current_step_order === $step->step_order;
                                    @endphp

                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $step->step_order }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $step->approver?->name ?? __('Deleted approver') }}
                                            @if ($step->approver?->email)
                                                <div class="text-xs text-gray-500">{{ $step->approver->email }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if ($action)
                                                <span @class([
                                                    'font-medium',
                                                    'text-green-700' => $action->action === \App\Enums\ApprovalActionType::Approved,
                                                    'text-red-700' => $action->action === \App\Enums\ApprovalActionType::Rejected,
                                                ])>
                                                    {{ $action->action->name }}
                                                </span>
                                            @elseif ($isCurrent)
                                                <span class="font-medium text-yellow-700">{{ __('Current') }}</span>
                                            @elseif ($isWithdrawnStep)
                                                <span class="font-medium text-gray-700">{{ __('Withdrawn') }}</span>
                                            @else
                                                <span class="text-gray-500">{{ __('Waiting') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $action && filled($action->comment) ? $action->comment : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Approval Actions') }}</h3>

                    @if ($approvalRequest->actions->isEmpty())
                        <p class="mt-4 text-sm text-gray-600">
                            {{ __('No approval actions have been taken yet.') }}
                        </p>
                    @else
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Step</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Approver</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comment</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acted At</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($approvalRequest->actions as $action)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ $action->workflowStep?->step_order ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ $action->approver?->name ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <span @class([
                                                    'font-medium',
                                                    'text-green-700' => $action->action === \App\Enums\ApprovalActionType::Approved,
                                                    'text-red-700' => $action->action === \App\Enums\ApprovalActionType::Rejected,
                                                ])>
                                                    {{ $action->action->name }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ filled($action->comment) ? $action->comment : '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ $action->acted_at?->format('Y-m-d H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end">
                @if ($approvalRequest->status === \App\Enums\ApprovalRequestStatus::Pending)
                    <button
                        type="button"
                        wire:click="withdraw"
                        wire:confirm="Withdraw this request?"
                        class="me-4 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500"
                    >
                        {{ __('Withdraw Request') }}
                    </button>
                @endif

                <a
                    href="{{ route('my-requests.index') }}"
                    wire:navigate
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    {{ __('Back to My Requests') }}
                </a>
            </div>
        </div>
    </div>
</div>
